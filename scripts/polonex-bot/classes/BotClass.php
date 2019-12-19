<?
/* Подключаемся к Polonex, забираем актуальный OrderBook
https://poloniex.com/public?command=returnOrderBook&currencyPair=BTC_XMR&depth=20
*/

Class Bot {

    var $pair1;
    var $pair2;
    var $depth;

    function __construct($pair1, $pair2, $depth){
        $this->pair1 = $pair1;
        $this->pair2 = $pair2;
        $this->depth = $depth;
    }

    protected function GetJsonByHttp($url, $data_json = '') {
        $curl = curl_init($url); // run cli-wallet at port 8091
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, true);

        return $result;
    }

    //========= Sends data to cli-wallet =============
    protected function sendJsonToCliWallet(string $method, $arParams = [''], $ignoreErr = true) {
    
        $url = 'http://localhost:8091/';

        $data = [
            "jsonrpc" => "2.0", 
            "id" => 1, 
            "method" => $method,
            "params" => $arParams
        ];

        $data_json = json_encode($data); //paste data into json
    
        $arResult = $this->GetJsonByHttp($url, $data_json);

        if (isset($arResult) and !empty($arResult)) {
            if (isset($arResult['error']['message']) and !empty($arResult['error']['message'])) {
                if ($ignoreErr != true) {
                    die('Stopped with error: <b>' . $arResult['error']['message'] . '</b>');
                } else {
                    PR($arResult['error']['message']);
                }
            } else {
                return $arResult['result'];
                PR($arResult);
            }
        } else {
            die('Lost connection to the CLI wallet');
        }
        //PR($arResult);
    }

    // =========== Получаем фиды с Полонекса =============
    public function getOrderBook() {

        global $percent;
    
        $url = 'https://poloniex.com/public?command=returnOrderBook&currencyPair=' . $this->pair1 . '_' . $this->pair2 .  '&depth=' . $this->depth;
        $arResult = $this->GetJsonByHttp($url);

        $arAsks = [];
        $arBids = [];
    
        foreach ($arResult['asks'] as $value) {
            array_push($arAsks, array( number_format( ($value[0] * (1 + ($percent/100))) * $value[1], 6 ), number_format( $value[1], 6 ) ) );
        }
    
        foreach ($arResult['bids'] as $value) {
            array_push($arBids, array( number_format( ($value[0] * (1 - ($percent/100))) * $value[1], 6 ), number_format( $value[1], 6 ) ) );
        }
    
        $arLocal['asks'] = $arAsks;
        $arLocal['bids'] = $arBids;
    
        return $arLocal;
        //asks - сколько первой валюты нужно купить
        //bids - сколько первой валюты нужно продать
        //[0] - количество первой валюты
        //[1] - количество второй валюты
    }
    
    // =========== Получаем фиды с Локалкоина =============
    private function getLimitOrdersLLC($limit = 100) {
        
        global $userIDs;
        //get_limit_orders XMR BTC 100
    
        $curl_data = [
            $this->pair2,
            $this->pair1,
            $limit
        ];
    
        $result = $this->sendJsonToCliWallet('get_limit_orders', $curl_data);
    
        $arMyOrders = [];
        $arMyOrdersAsks = [];
        $arMyOrdersBids = [];

        $pair1ID = $this->sendJsonToCliWallet('get_asset', [$this->pair1]);

        foreach ($result as $value) {
            //if (in_array($value['seller'], $userIDs)) {
            if ($value['seller'] == $userIDs[0] || $userIDs[1] || $userIDs[2] || $userIDs[3] || $userIDs[4] || $userIDs[5] || $userIDs[6] || $userIDs[7] || $userIDs[8] || $userIDs[9]) {                
                if ($value['sell_price']['base']['asset_id'] != $pair1ID['id']) {
                    array_push($arMyOrdersAsks, $value);
                } else {
                    array_push($arMyOrdersBids, $value);
                }
            }
        }
        $arMyOrders['asks'] = $arMyOrdersAsks;
        $arMyOrders['bids'] = $arMyOrdersBids;
    
        return $arMyOrders;
    }
    
    //======== Получаем список совпадающих ордеров ===============
    public function getProperOrdersID() {
        
        $polonexOrders = $this->getOrderBook();
        $localcoinOrders = $this->getLimitOrdersLLC();
    
        $matchIDs = [];
    
        foreach ($polonexOrders['asks'] as $polValue) {
            foreach ($localcoinOrders['asks'] as $locValue) {
                if ( $polValue[1] == ($locValue['sell_price']['base']['amount'] / 1000000) ) {
                    array_push($matchIDs, $locValue['id']);
                }
            }
        }
    
        foreach ($polonexOrders['bids'] as $polValue) {
            foreach ($localcoinOrders['bids'] as $locValue) {
                if ( $polValue[1] == ($locValue['sell_price']['quote']['amount'] / 1000000) ) {
                    array_push($matchIDs, $locValue['id']);
                }
            }
        }
    
        return $matchIDs;
    }
    
    //======== Получаем список несовпадающих ордеров на Локалкоин к удалению ===============
    public function getOldOrdersID() {
        $matchIDs = $this->getProperOrdersID($limit = 100);
    
        $curl_data = [
            $this->pair2,
            $this->pair1,
            $limit
        ];
    
        $getLimitOrders =  $this->sendJsonToCliWallet('get_limit_orders', $curl_data);
        $arMyOrdersID = [];
        foreach ($getLimitOrders as $value) {
            array_push($arMyOrdersID, $value['id']);
        }
    
        $_result = array_diff($arMyOrdersID, $matchIDs);
        $result = array_values($_result);
        return $result;
    }
    
    //======== Получаем список не совпадающих ордеров на Полониксе к созданию ==========
    public function getNewOrdersID() {

        $polonexOrders = $this->getOrderBook();
        $localcoinOrders = $this->getLimitOrdersLLC();
    
        //PR($polonexOrders['asks']);
        //PR($localcoinOrders);
    
        $arPolAsks = array_column($polonexOrders['asks'],1);
        $arLocAsks = [];
        foreach ($localcoinOrders['asks'] as $value) {
            array_push($arLocAsks, number_format( $value['sell_price']['base']['amount'] / 1000000, 6) );
        }
        $matchAsks = array_diff($arPolAsks, $arLocAsks); // Ищем суммы которых нет на Localcoin
    
        $newAsks = [];//Список ASKS которые нужно создать
        foreach ($matchAsks as $value) {
            $key = array_search($value, array_column($polonexOrders['asks'], 1));
            if (isset($key)) {
                array_push($newAsks, $polonexOrders['asks'][$key]);
            }
        }
        //PR($newAsks);
    
        $arPolBids = array_column($polonexOrders['bids'],1);
        $arLocBids = [];
        foreach ($localcoinOrders['bids'] as $value) {
            array_push($arLocBids, number_format( $value['sell_price']['quote']['amount'] / 1000000, 6) );
        }
        $matchBids = array_diff($arPolBids, $arLocBids); // Ищем суммы которых нет на Localcoin
    
        $newBids = [];//Список BIDS которые нужно создать
        foreach ($matchBids as $value) {
            $key = array_search($value, array_column($polonexOrders['bids'], 1));
            if (isset($key)) {
                array_push($newBids, $polonexOrders['bids'][$key]);
            }
        }
        //PR($newBids);    
    
        $arNewOrder['asks'] = $newBids;
        $arNewOrder['bids'] = $newAsks;
        return $arNewOrder;
    }


    public function printOrders() {
        /* =========== Дебаг отчет по заявкам ================= */
        echo 'ID заявок которые нужно оставить <br>';
        PR($this->getProperOrdersID());
        echo 'ID заявок которые нужно удалить <br>';
        PR($this->getOldOrdersID());
        echo 'Заявки которые нужно создать <br>';
        PR($this->getNewOrdersID());
    }

    public function CreateAsk($bullet) {
        global $userIDs;

        //Зеленые
        /*
        метод sell_asset 
        seller_account: xmr / 1.2.69443
        amount_to_sell: 4.87305691 * 0.00715999
        symbol_to_sell: btc / 1.3.1
        min_to_receive: 4.87305691
        symbol_to_receive: xmr / 1.3.116
        timeout_sec: 3600
        fill_or_kill: true
        broadcast: true
        */
        $curl_data = [
            //'localcoin-wallet',
            $userIDs[array_rand($userIDs)],
            $bullet[0],
            $this->pair1,
            $bullet[1],
            $this->pair2,
            $timeout,
            false,
            true
        ];

        $this->sendJsonToCliWallet('sell_asset', $curl_data);
        usleep(rand(10000, 100000));
    }

    public function CreateBid($bullet) {
        global $userIDs;

        //Красные
        /*
        метод sell_asset 
        seller_account: xmr / 1.2.69443
        amount_to_sell: 32.00714763
        symbol_to_sell: xmr / 1.3.116
        min_to_receive: 32.00714763 * 0.00714502
        symbol_to_receive: btc / 1.3.1
        timeout_sec: 3600
        fill_or_kill: true
        broadcast: true
        */

        $curl_data = [
            //'localcoin-wallet',
            $userIDs[array_rand($userIDs)],
            $bullet[1],
            $this->pair2,
            $bullet[0],
            $this->pair1,
            $timeout,
            false,
            true
        ];
        
        $this->sendJsonToCliWallet('sell_asset', $curl_data);
        usleep(rand(10000, 100000));
    }

    protected function DeleteOrder($bullet) {
        $curl_data = [
            $bullet,
            true
        ];
        
        $this->sendJsonToCliWallet('cancel_order', $curl_data);    
        usleep(rand(10000, 100000));    
    }    

    function GetActionList() {

        $arListToInvoke = [];
        $arOrdersToCreate = $this->getNewOrdersID();
        foreach($arOrdersToCreate['asks'] as $value) {
            array_push($arListToInvoke, ['invoker' => 'CreateAsk', 'feed' => $value ]);
        }
        foreach($arOrdersToCreate['bids'] as $value) {
            array_push($arListToInvoke, ['invoker' => 'CreateBid', 'feed' => $value ]);
        }
        $arOrdersToDelete = $this->getOldOrdersID();
        foreach($arOrdersToDelete as $value) {
            array_push($arListToInvoke, ['invoker' => 'DeleteOrder', 'feed' => $value ]);
        }

        //PR($arListToInvoke);

        return $arListToInvoke;
    }

    //========= Создаём ордера на основе собранных данных =============
    function run($debug = false) {
        global $userIDs;
        global $timeout;
    
        if ($debug == true) {
            $CreateReport = $this->getNewOrdersID();
            $Report = count($CreateReport['asks']) + count($CreateReport['bids']);
            echo '<h3>Создал ' . $Report . '</h3>';
            echo '<h3>Удалил ' . count($this->getOldOrdersID()) . '</h3>';
        }
    
        global $walletPass;
        global $arWitnessess;
    
        if ($this->sendJsonToCliWallet('is_locked') == '1') { // Unlocks wallet
            $this->sendJsonToCliWallet('unlock', [$walletPass]);
        }
    
        $arPrivkeys = $this->sendJsonToCliWallet('dump_private_keys'); // Check private keys in your cli-wallet
        foreach($arPrivkeys as $value) {
            $arPubkeys []= $value[0];
        }
    
        foreach ($arWitnessess as $value) {
            $check = array_key_exists($value, array_flip($arPubkeys));
            if (!$check) {
                die('Check your config, wallet doesn\'t have enought keys.');
            }
        }
    
        $list = $this->GetActionList();
        shuffle($list);
        //PR($list);
        foreach ($list as $item) {
            $bullet = $item['feed'];
            call_user_func(array($this, $item['invoker']), $bullet);
        }


        /*
        $deleteOrders = $this->getOldOrdersID();
        foreach ($deleteOrders as $value) {
            $curl_data = [
                $value,
                true
            ];
            
            $this->sendJsonToCliWallet('cancel_order', $curl_data);
            usleep(rand(10000, 100000));
        }	
        
        $polonexOrders = $this->getNewOrdersID();
    
        foreach ($polonexOrders['asks'] as $bid) { // У полонекса заявки наоборот
            //Зеленые
            //$arAsk = [];
            //round($ask[0], 6, PHP_ROUND_HALF_EVEN);
            //round($ask[1], 6, PHP_ROUND_HALF_EVEN);
            
            //PR( number_format( round($ask[0], 6, PHP_ROUND_HALF_EVEN), 6) );
    
            /*
            метод sell_asset 
            seller_account: xmr / 1.2.69443
            amount_to_sell: 4.87305691 * 0.00715999
            symbol_to_sell: btc / 1.3.1
            min_to_receive: 4.87305691
            symbol_to_receive: xmr / 1.3.116
            timeout_sec: 3600
            fill_or_kill: true
            broadcast: true
            */
            /*
            $curl_data = [
                //'localcoin-wallet',
                $userIDs[array_rand($userIDs)],
                $bid[0],
                $this->pair1,
                $bid[1],
                $this->pair2,
                $timeout,
                false,
                true
            ];
    
            $this->sendJsonToCliWallet('sell_asset', $curl_data);
            //echo 'Создал BID:<br>';
            //PR($curl_data);
            usleep(rand(10000, 100000)); // timeout for each operation, if disable cli-wallet could crash
        }
    
        foreach ($polonexOrders['bids'] as $ask) { // У полонекса заявки наоборот
            //Красные
            //PR($bid);
            //PR( number_format( round($ask[0], 6, PHP_ROUND_HALF_EVEN), 6) );
    
            /*
            метод sell_asset 
            seller_account: xmr / 1.2.69443
            amount_to_sell: 32.00714763
            symbol_to_sell: xmr / 1.3.116
            min_to_receive: 32.00714763 * 0.00714502
            symbol_to_receive: btc / 1.3.1
            timeout_sec: 3600
            fill_or_kill: true
            broadcast: true
            */
            /*
            $curl_data = [
                //'localcoin-wallet',
                $userIDs[array_rand($userIDs)],
                $ask[1],
                $this->pair2,
                $ask[0],
                $this->pair1,
                $timeout,
                false,
                true
            ];
            
            $this->sendJsonToCliWallet('sell_asset', $curl_data);
            //echo 'Создал ASK:<br>';
            //PR($curl_data);
            usleep(rand(10000, 100000)); // timeout for each operation, if disable cli-wallet could crash        
        }

        */
    }

}
?>