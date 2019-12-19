<?require($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/init.php");

if ($_GET['key'] != 'startexp') die('invalid key');

$USDT_BTC = new Bot('USDT','BTC','30');
$USDT_BTC->run();

////https://poloniex.com/public?command=returnOrderBook&currencyPair=BTC_XMR&depth=10
//https://poloniex.com/public?command=returnOrderBook&currencyPair=USDT_XMR&depth=10
//https://poloniex.com/public?command=returnOrderBook&currencyPair=USDC_XMR&depth=10
//https://poloniex.com/public?command=returnOrderBook&currencyPair=BTC_ETH&depth=10
//https://poloniex.com/public?command=returnOrderBook&currencyPair=USDT_BTC&depth=10
//https://poloniex.com/public?command=returnOrderBook&currencyPair=USDC_ETH&depth=10
?>