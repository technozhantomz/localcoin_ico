<?require($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/init.php");

if ($_GET['key'] != 'startexp') die('invalid key');

$fillpair = new Bot($_GET['pair1'], $_GET['pair2'],'30');
$fillpair->run();

//?key=startexp&pair1=BTC&pair2=ETH
//?key=startexp&pair1=BTC&pair2=XMR

//?key=startexp&pair1=USDC&pair2=ETH
//?key=startexp&pair1=USDC&pair2=XMR
//?key=startexp&pair1=USDC&pair2=BTC

//?key=startexp&pair1=USDT&pair2=BTC
//?key=startexp&pair1=USDT&pair2=ETH
//?key=startexp&pair1=USDT&pair2=XMR

?>