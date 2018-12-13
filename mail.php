<?php 
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "from@localcoin.is";
    $to = "hor@tut.by";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "Test email sent";
?>