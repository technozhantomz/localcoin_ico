<?php
$access_key = '3d412586b14709b75ef2cb90703cac8a';
$apiKeyTransaction = "5KJgab4NcbBXqAo6eFktvDaJfMQBmwD6LGeVJ26R2XB584zShhZ";

$dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/coin/LocalCoin.csv');
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

$data_json_key = '
{
    "jsonrpc": "2.0",
    "id": 1,
    "method": "import_key",
    "params": [
    "localcoin-wallet",
    "' . $apiKeyTransaction . '"
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

$data_02 = getCurl(
    $curl,
    'http://194.63.142.61:8091/rpc',
    array(
        array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_key)))
    ),
    $data_json_key
);


$from = 'USD';
$to = 'EUR';
$amount = 1;

$ch = curl_init('https://data.fixer.io/api/convert?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount . '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);

$conversionResult = json_decode($json, true);
$usdToEur = $conversionResult['result'];

$ch = curl_init('https://data.fixer.io/api/latest?access_key=' . $access_key . '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($ch);
curl_close($ch);

$exchangeRates = json_decode($json, true);

$arAsset = array();
$n = 0;
$arAsset = getAssets('', $n, $curl, $arAsset, $arCoin);
$arCoinSmart = array();
foreach ($exchangeRates["rates"] as $keyCoin => $valCoin) {
    $arCoinSmart[$keyCoin] = array(
        "EUR" => $valCoin,
        "LLC" => $valCoin * $usdToEur / 2,
    );

    if (empty($arCoin[$keyCoin]) || empty($arAsset[$keyCoin])) {
        continue;
    }

    $data_json_03 = '
       {
 "jsonrpc": "2.0",
 "id": 1,
 "method": "publish_asset_feed",
 "params": [
    "' . $arAsset[$keyCoin] . '",
    "1.3.0",
    
       {
            "settlement_price": {
              "base": {
                "amount": 10000,
                "asset_id": "1.3.0" },
              "quote": {
                "amount": ' . ($valCoin * $usdToEur / 2 * 10000) . ',
                "asset_id": "' . $arAsset[$keyCoin] . '" }
            },
            "maintenance_collateral_ratio": 1750,
            "maximum_short_squeeze_ratio": 1200,
            "core_exchange_rate": {
              "base": {
                "amount": 10000,
                "asset_id": "1.3.0" },
              "quote": {
                "amount": ' . ($valCoin * $usdToEur / 2 * 10000) . ',
                "asset_id": "' . $arAsset[$keyCoin] . '" }
            }
        }
    ,
    "true"
  ]
}
                    ';

    $data_03 = getCurl(
        $curl,
        'http://194.63.142.61:8091/rpc',
        array(
            array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_03)))
        ),
        $data_json_03
    );
    //echo print_r($data_03, true);
    //die();
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

function getAssets($start, $n, $curl, $assets = array(), $arCoin)
{
    $data_json_list = '
     {
        "jsonrpc": "2.0",
        "id": 1
        "method": "list_assets",
        "params": ["' . $start . '" , "100"],
    }
        ';

    $data_list = getCurl(
        $curl,
        'http://194.63.142.61:8091/rpc',
        array(
            array(CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json_list)))
        ),
        $data_json_list
    );

    $obList = json_decode($data_list);

    $lastCoin = "";
    foreach ($obList->result as $item) {

        if (in_array($item->symbol, $arCoin)) {
            $assets[$item->symbol] = $item->id;
        }
        $lastCoin = $item->symbol;
    }

    $n++;

    if ($start == $lastCoin || $n >= 10) {
        return $assets;
    } else {
        return getAssets($lastCoin, $n, $curl, $assets, $arCoin);
    }

}