<?require_once($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/init.php");
//require('/classes/BotClass.php'); 
/*
Написать класс, который из заданной пары будет создавать две встречные сделки.
Одна сделка на покупку, вторая на продажу.
Делать это должны случайные юзеры из нашего списка.

1. Получить список всех текущих стаканов нужной пары
2. Найти лучшую сделку на продажу
2.1 Высчитать цену этой сделки
3. Найти лучшую сделку на покупку
3.1 Высчитать цену этой сделки
4. Выбрать случайного юзера
5. Сгенерить сделку от случайного юзера сделку покупку или продажу добавив (диапазон 0.000000001 и 0.00005) к цене лучшей сделки или вычев
6. Сгенерить встречную сделку от другого, неповторяющего юзера из п.5
*/

Class Pump {

    var $pair1;
    var $pair2;
    private $MarketData;

    function __construct($pair1, $pair2) {
        $this->pair1 = $pair1;
        $this->pair2 = $pair2;
        $this->MarketData = new Bot($pair1, $pair2, 30); //30 пока хардкод так как всеравно нужен только верх стакана
    }

    function getBestPrice() {
        //PR($this->MarketData->getOrderBook());
        $arOrderList = $this->MarketData->getOrderBook();

        $topPrice['asks'] = number_format( $arOrderList['asks'][0][0] / $arOrderList['asks'][0][1], 6 );
        $topPrice['bids'] = number_format( $arOrderList['bids'][0][0] / $arOrderList['bids'][0][1], 6 );
        
        //PR($topPrice);

        return $topPrice;
        //PR($arOrderAskPrice); // красные, на продажу чем меньше тем выше
        //PR($arOrderBidPrice); // зеленые на покупку, чем больше тем выше
    }

    function getRandomUser() {
        global $userIDs;
        return $userIDs[array_rand($userIDs)];
    }

    function createBestBid($debug = false) {
        //красная колонка
        $arOrderList = $this->MarketData->getOrderBook(); // получаем список сделок
        $topPrice = $this->getBestPrice(); //и лучшие цены
        
        //PR($arOrderList);
        $random = number_format((rand(1, 10) / 100000), 6);
        $bestPriceRed = $topPrice['asks'] - $random; // повышаем цену на красные
        $bullet = [ number_format($arOrderList['asks'][0][1] * $bestPriceRed, 6), $arOrderList['asks'][0][1] ];
        
        $this->MarketData->CreateBid($bullet);
        $this->MarketData->CreateAsk($bullet);

        if ($debug == true) {
            echo 'Красная ставка:<br>';
            echo 'лучшая цена<br>';
            PR($topPrice['asks']);
            echo 'наша цена<br>';
            PR($bestPriceRed);
            echo 'лучшая ставка<br>';
            PR($arOrderList['asks'][0]);
            echo 'наша ставка<br>';
            PR($bullet);
        }
    }

    function createBestAsk($debug = false) {
        //зеленая колонка
        $arOrderList = $this->MarketData->getOrderBook(); // получаем список сделок
        $topPrice = $this->getBestPrice(); //и лучшие цены
        
        //PR($arOrderList);
        $random = number_format((rand(1, 10) / 100000), 6);
        $bestPriceRed = $topPrice['bids'] + $random; // повышаем цену на красные
        $bullet = [ number_format($arOrderList['bids'][0][1] * $bestPriceRed, 6), $arOrderList['bids'][0][1] ];
        
        $this->MarketData->CreateAsk($bullet);
        $this->MarketData->CreateBid($bullet);

        if ($debug == true) {
            echo 'Зеленая ставка:<br>';
            echo 'лучшая цена<br>';
            PR($topPrice['bids']);
            echo 'наша цена<br>';
            PR($bestPriceRed);
            echo 'лучшая ставка<br>';
            PR($arOrderList['bids'][0]);
            echo 'наша ставка<br>';
            PR($bullet);
        }
    }    

    function run() {

        $random = rand(0,5);
        if ($random == 0) {
            $this->createBestBid(true);
        } elseif ($random == 1) {
            $this->createBestAsk(true);
        } else {
            die();
        }
    }
    
}
?>
