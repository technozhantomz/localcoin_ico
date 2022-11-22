<?php
//Создаёт вебсокет соединение к ноде, отправляет и принимает запросы на ноду.
namespace localcoinapi;

require_once 'vendor\autoload.php';
require_once 'config\config.php';

use WebSocket\Client;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

// Create a log channel
/*
$log = new Logger('websocketLog');
$log->pushHandler(new StreamHandler('../log/websocket.log', Logger::DEBUG));
$log->warning('Foo');
$log->error('Bar');
*/

/* Connect to RPC Endpoint */
//$client = new Client("ws://127.0.0.1:8090");

//$client->send( generate_json_rpc( 3, 'get_account_history', '["1.2.17", "1.11.0", 50, "1.11.9999999999999"]', 4) );
//$get_account_history = json_decode( $client->receive() );
/* 
function generate_json_rpc( $type_id, $method, $params, $sequence_id ){
	return '{
		"jsonrpc": "2.0", 
		"method": "call", 
		"params": [' . $type_id . ', "' . $method . '", ' . $params . ' ],
		"id": ' . $sequence_id . '
	}';
}

function pr( $obj ){
    echo '<pre>';
    print_r( $obj );
    echo '</pre>';
 }
 */
// pr($get_account_history);
//echo $get_account_history->error->code;

/* 
$client->send( generate_json_rpc( 1, 'login', '["", ""]', 1) );
$client->receive();
$client->send( generate_json_rpc( 1, 'database', '[]', 2) );
$client->receive();
$client->send( generate_json_rpc( 1, 'history', '[]', 4) );
$client->receive();
$client->send( generate_json_rpc( 3, 'get_account_history', '["1.2.17", "1.11.0", 50, "1.11.9999999999999"]', 4) );
$get_account_history = json_decode( $client->receive() );
pr( $get_account_history ); */

?>