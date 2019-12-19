<?require_once($_SERVER["DOCUMENT_ROOT"] . "/scripts/polonex-bot/init.php");

if ($_GET['key'] != 'startexp') die('invalid key');

$BTC_XMR = new Pump('BTC', 'XMR');
$BTC_XMR->run();

?>