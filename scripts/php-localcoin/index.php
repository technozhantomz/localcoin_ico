<?php
require 'utils/debug.php';
require_once 'vendor/autoload.php';
require_once 'config/config.php';

use WebSocket\Client;

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();



//pr($_SERVER);

?>