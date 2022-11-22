<?require_once($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/init.php");
if ($_GET['key'] != 'startexp') die('invalid key');

$BTC_XMR = new Pump($_GET['pair1'], $_GET['pair2']);
$BTC_XMR->run();

?>