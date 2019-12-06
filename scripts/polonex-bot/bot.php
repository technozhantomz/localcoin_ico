<?require($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/config.php");
/* Подключаемся к Polonex, забираем актуальный OrderBook
https://poloniex.com/public?command=returnOrderBook&currencyPair=BTC_XMR&depth=20
*/

echo '<a href="index.php">Назад к форме запуска</a>';

if ($_GET['key'] != 'startexp') die('invalid key');
if (!empty($_GET['orderCount']) && isset($_GET['orderCount'])) $orderCount = $_GET['orderCount'];
if (!empty($_GET['orderLife']) && isset($_GET['orderLife'])) $timeout = $_GET['orderLife'];

//PR($userIDs[array_rand($userIDs)]);
// =========== Получаем фиды с Полонекса =============
function getOrderBook($pair, $depth) {

    global $testFeed;

    $url = 'https://poloniex.com/public?command=returnOrderBook&currencyPair=' . $pair .  '&depth=' . $depth;
    $curl = curl_init($url); // run cli-wallet at port 8091

    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($curl);
    curl_close($curl);
    
    //$arResult = json_decode($testFeed, true);
    $arResult = json_decode($result, true);
    $arAsks = [];
    $arBids = [];
    //PR($arResult);

    foreach ($arResult['asks'] as $value) {
        array_push($arAsks, array( number_format( $value[0] * 1.005 * $value[1], 6 ), number_format( $value[1], 6 ) ) );
    }

    foreach ($arResult['bids'] as $value) {
        array_push($arBids, array( number_format( $value[0] * 0.995 * $value[1], 6 ), number_format( $value[1], 6 ) ) );
    }

    $arLocal['asks'] = $arAsks;
    $arLocal['bids'] = $arBids;

    return $arLocal;
    //asks - сколько первой валюты нужно купить
    //bids - сколько первой валюты нужно продать
    //[0] - количество первой валюты
    //[1] - количество второй валюты
}
echo '<h2>Список заявок к созданию</h2>';
PR(getOrderBook('BTC_XMR', $orderCount));

// =========== Получаем фиды с Локалкоина =============
function getLimitOrdersLLC($pair1, $pair2, $limit) {
    global $userIDs;
    //get_limit_orders XMR BTC 100

    $curl_data = [
        $pair1,
        $pair2,
        $limit
    ];

    $result = sendCurl('get_limit_orders', $curl_data);

    /*
    foreach ($result as $value) {
        $baseAmount = $value['sell_price']['base']['amount'] / 1000000;
        $quoteAmount = $value['sell_price']['quote']['amount'] / 1000000;

        if ($value['sell_price']['base']['asset_id'] != '1.3.1') {
            $price = $quoteAmount / $baseAmount;
        } else {
            $price = $baseAmount / $quoteAmount;
        }
        PR( number_format( $price, 6 ) );
    }
    */

    $arMyOrders = [];
    $arMyOrdersAsks = [];
    $arMyOrdersBids = [];
    foreach ($result as $value) {
        if ($value['seller'] == $userIDs[0] || $userIDs[1] || $userIDs[2] || $userIDs[3] || $userIDs[4] || $userIDs[5] || $userIDs[6] || $userIDs[7] || $userIDs[8] || $userIDs[9]) {
            if ($value['sell_price']['base']['asset_id'] != '1.3.1') {
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
function getProperOrdersID() {
	global $orderCount;
	
    $polonexOrders = getOrderBook('BTC_XMR', $orderCount);
    $localcoinOrders = getLimitOrdersLLC('XMR', 'BTC', '100');

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
function getOldOrdersID() {
    $matchIDs = getProperOrdersID();

    $curl_data = [
        'XMR',
        'BTC',
        '100'
    ];

    $getLimitOrders = sendCurl('get_limit_orders', $curl_data);
    $arMyOrdersID = [];
    foreach ($getLimitOrders as $value) {
        array_push($arMyOrdersID, $value['id']);
    }

    $result = array_diff($arMyOrdersID, $matchIDs);
    return $result;
}

//======== Получаем список не совпадающих ордеров на Полониксе к созданию ==========
function getNewOrdersID() {
	global $orderCount;
    $polonexOrders = getOrderBook('BTC_XMR', $orderCount);
    $localcoinOrders = getLimitOrdersLLC('XMR', 'BTC', '100');

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

/* =========== Дебаг отчет по заявкам ================= */
/*
echo 'ID заявок которые нужно оставить <br>';
PR(getProperOrdersID());
echo 'ID заявок которые нужно удалить <br>';
PR(getOldOrdersID());
echo 'Заявки которые нужно создать <br>';
PR(getNewOrdersID());
/**/

//========= Создаём ордера на основе собранных данных =============
function CreateOrders() {
    global $userIDs;
    global $timeout;

    $CreateReport = getNewOrdersID();
    $Report = count($CreateReport['asks']) + count($CreateReport['bids']);
    echo '<h3>Создал ' . $Report . '</h3>';
    echo '<h3>Удалил ' . count(getOldOrdersID()) . '</h3>';

    global $walletPass;
    global $arWitnessess;

    if (sendCurl('is_locked') == '1') { // Unlocks wallet
        sendCurl('unlock', [$walletPass]);
    }

    $arPrivkeys = sendCurl('dump_private_keys'); // Check private keys in your cli-wallet
    foreach($arPrivkeys as $value) {
        $arPubkeys []= $value[0];
    }

    foreach ($arWitnessess as $value) {
        $check = array_key_exists($value, array_flip($arPubkeys));
        if (!$check) {
            die('Check your config, wallet doesn\'t have enought keys.');
        }
    }    

    $polonexOrders = getNewOrdersID();

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
        
        $curl_data = [
            //'localcoin-wallet',
            $userIDs[array_rand($userIDs)],
            $bid[0],
            'BTC',
            $bid[1],
            'XMR',
            $timeout,
            false,
            true
        ];

        sendCurl('sell_asset', $curl_data);
        echo 'Создал BID:<br>';
        PR($curl_data);
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

        $curl_data = [
            //'localcoin-wallet',
            $userIDs[array_rand($userIDs)],
            $ask[1],
            'XMR',
            $ask[0],
            'BTC',
            $timeout,
            false,
            true
        ];
        
        sendCurl('sell_asset', $curl_data);
        echo 'Создал ASK:<br>';
        PR($curl_data);
        usleep(rand(10000, 100000)); // timeout for each operation, if disable cli-wallet could crash        
    }

    $deleteOrders = getOldOrdersID();
    foreach ($deleteOrders as $value) {
        $curl_data = [
            $value,
            true
        ];
        
        sendCurl('cancel_order', $curl_data);
        echo 'Удалил:<br>';
        PR($curl_data);
        usleep(rand(10000, 100000));
    }
}

CreateOrders();

//========= Sends data to cli-wallet =============
function sendCurl(string $method, $arParams = [''], $ignoreErr = true) {

    $curl = curl_init("http://localhost:8091/"); // run cli-wallet at port 8091

    $data = [
        "jsonrpc" => "2.0", 
        "id" => 1, 
        "method" => $method,
        "params" => $arParams
    ];


    $data_json = json_encode($data); //paste data into json

    //PR($data_json);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    curl_close($curl);

    $arResult = json_decode($result, true);
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

//========= Debug scripts =============
function PR($o, $show = false) {
    global $USER;
        $bt = debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div style='font-size: 12px;font-family: monospace;width: 100%;color: #181819;background: #EDEEF8;border: 1px solid #006AC5;'>
            <div style='padding: 5px 10px;font-size: 10px;font-family: monospace;background: #006AC5;font-weight:bold;color: #fff;'>File: <?= $bt["file"] ?> [<?= $bt["line"] ?>]</div>
            <pre style='padding:10px;'><? print_r($o) ?></pre>
        </div>
        <?
}

?>