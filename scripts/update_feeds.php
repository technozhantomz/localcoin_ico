<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';

$privateKeyData = array(
    "5KE6eZe24XDGrAPkfZro97DzUXQHEiSYtEPZaGzPDgJw5uibEik",
    "5JmpFxQxdE7d4ApLxEaSwCSiBKoD1j7BqLpsAf6G7aPz5KTmKTf",
	"5KVXhrvMKTcG1gu8T62RUXqi1umD3u83YvbYhmSmjYD6hv1f11E",
	"5KJzH3RaUA9W9QBp5rjePMBPco83PoFdX3RaFtGUDnT5Cj7uZmj",
	"5KC62eHhS6FVnuZJm6pF2TTFBbfP8d6qpgCHX9Ks1yyybi5sCKn",
	"5HyvyovXMEzFdbM5BXeXLQm9zdDum8q5MfA4NPUAuVatnUkxFay",
	"5K1s4ru4TEoAePvhYFYGeE51LpagkFPXdVroMZqwM5Ae6695uQR",
	"5JLjdsHfRzuKYciUMbLMTrSFtPPWKUU8LRMQ1bza4BHdMAbWp6h",
	"5KbJaXtLv91beTBbJqjrXw3jsGyR8TutLJ9hQHqAurS9FcsjpTh",
	"5JkJ7rzP2EgoS2u3pvM9mQP69kxfbyLMmj448caHVZgDgPx77vv"
);
$userNameData = array(
    "adamgottie",
    "aaronson",
	"ampleforth",
	"charrington",
	"julia",
	"obrien",
	"winstonsmith",
	"sentriusfounders",
	"stoneman",
	"testnet-acc"
);

$access_key = '3d412586b14709b75ef2cb90703cac8a';
//$apiKeyTransaction = "5KE6eZe24XDGrAPkfZro97DzUXQHEiSYtEPZaGzPDgJw5uibEik";

$dataCsv = file_get_contents('/var/www/localcoin.is/public_html/scripts/LocalCoinSmart.csv');
$arRow = str_getcsv($dataCsv, "\r");

$arCoin = array();
foreach ($arRow as $keyRow => $rowCsv) {
    if ($keyRow <= 0) {
        continue;
    }
    $arCol = str_getcsv($rowCsv, ",");
    $arCol[0] = trim($arCol[0]);

    if ($arCol[0] == "ALQO" || $arCol[0] == '$PAC') {
        continue;
    }

    $arCoin[$arCol[0]] = $arCol[0];
}

if (empty($arCoin)) {
    die();
}

$curl = curl_init();

$data_json_unlock = '
{
    "jsonrpc": "2.0",
    "id": 1,
    "method": "unlock",
    "params": [
    "testpass"
    ]
}
';
$data_01 = getCurl(
    $curl,
    'http://194.63.142.61:8091/rpc',
    array(
        array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_unlock)))
    ),
    $data_json_unlock
);


/*
$from = 'USD';
$to = 'EUR';
$amount = 1;

$ch = curl_init('https://data.fixer.io/api/convert?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount . '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);

$conversionResult = json_decode($json, true);
$usdToEur = $conversionResult['result'];
*/

$ch = curl_init('https://data.fixer.io/api/latest?access_key=' . $access_key . '&base=USD');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);

$exchangeRates = json_decode($json, true);

foreach ($privateKeyData as $privateKey => $privateValue) {

    if (empty($userNameData[$privateKey])) {
        continue;
    }

    $data_json_key = '
{
    "jsonrpc": "2.0",
    "id": 1,
    "method": "import_key",
    "params": [
    "' . $userNameData[$privateKey] . '",
    "' . $privateValue . '"
    ]
}
';

    $data_02 = getCurl(
        $curl,
        'http://194.63.142.61:8091/rpc',
        array(
            array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_key)))
        ),
        $data_json_key
    );

    if (isset($_GET["debug"])) {
        $debug = json_decode($data_02, true);
        if (!empty($debug["error"])) {
            //echo "<br>method - import_key. Error: ".$debug["error"]["message"]; die();
            echo "<pre>" . print_r($data_02, true) . "</pre>";
            die();
        }
    }

    $precisionLocal =  100000;
    foreach ($exchangeRates["rates"] as $keyCoin => $valCoin) {
        //die();
//if($keyCoin != "USD"){continue;}
        
        $json_getId = '{"jsonrpc": "2.0",
                        "id": 1,
                        "method": "get_asset",
                        "params": [
                           "' . $keyCoin . '",
                         ]
                        }';

        $data_Id = getCurl(
            $curl,
            'http://194.63.142.61:8091/rpc',
            array(
                array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($json_getId)))
            ),
            $json_getId
        );
        $idSmart = json_decode($data_Id);

        if (empty($idSmart->result->id)) {
            continue;
        }

        if ($idSmart->result->precision >= 1) {
            $precision = pow(10, $idSmart->result->precision);
        } else {
            $precision = 100000;
        }


        $data_json_03 = '{"jsonrpc": "2.0",
"id": 1,
"method": "publish_asset_feed",
"params": [
   "' . $userNameData[$privateKey] . '",
   "' . $idSmart->result->id . '",
   
      {
           "settlement_price": {
             "base": {
               "amount": ' . ($valCoin / 2 *   $precision) . ',
               "asset_id": "' . $idSmart->result->id . '" },
             "quote": {
               "amount": ' . $precisionLocal . ',
               "asset_id": "1.3.0" }
           },
           "maintenance_collateral_ratio": 1750,
           "maximum_short_squeeze_ratio": 1200,
           "core_exchange_rate": {
             "base": {
               "amount": ' . ($valCoin / 2 *  $precision) . ',
               "asset_id": "' . $idSmart->result->id . '" },
             "quote": {
               "amount": ' . $precisionLocal . ',
               "asset_id": "1.3.0" }
           }
       }
   ,
   "true"
 ]
}';


        //echo "<pre>"; print_r(json_decode($data_json_03)); echo "</pre>";
        $data_03 = getCurl(
            $curl,
            'http://194.63.142.61:8091/rpc',
            array(
                array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_03)))
            ),
            $data_json_03
        );
  //echo print_r($data_03, true);    die();
        $errorNode = json_decode($data_03)->error->message;
        if(!empty($errorNode)){
            echo "ERROR (".$idSmart->result->id.") : ". print_r(json_decode($data_03)->error->message, true). "<br>";//         die();
            if(isset($_GET["debug"])){
               die();
            }
        }
    }
    if($_GET["key"] == "one"){
        die();
    }

}


curl_close($curl);

function getCurl($curl, $url, $hearder = array(), $post = array(), $postType = true)
{
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, $postType);
    foreach ($hearder as $head) {
        curl_setopt($curl, $head[0], $head[1]);
    }
    if (!empty($post)) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    $out = curl_exec($curl);
    return $out;
}

