<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//$curl_localhost = curl_init("http://localhost:8090/"); //подключаемся к локальной ноде
$curl = curl_init("https://moscow.localcoin.is/"); //подключаемся к локальной ноде

//формируем запрос
$data = [
    "jsonrpc" => "2.0", 
    "id" => "1", 
    "method" => "get_account_balances",
    "params" => [
        "1.2.45",
        ["1.3.0"]
    ]
];

$data_json = json_encode($data);//заворачиваем в json
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//забираем ответ в теле
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);//шлём POST с инфой

$result = curl_exec($curl);
curl_close($curl);

if (!empty($result)) {
    $balance_info = json_decode($result, true);
    if(isset($balance_info['result'][0]['amount']) and !empty($balance_info['result'][0]['amount'])) {
        $amount = $balance_info['result'][0]['amount']/100000;
        $time = time(); 
    
        $arrResult = [ // пишем баланс и время
            "amount" => $amount,
            "time" => $time
        ];
    
        $file = 'amount.json';//пишем в файл

        if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){//Читаем файл смартассетов, определяем переменную для крона
            $arrFile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' . $file);
        } else {
            $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
            $arrFile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts/' .$file);
        }

        //$arrFile = file_get_contents($file);
        $arrFile_ar = json_decode($arrFile, true);//забираем массив из файла
    
        $arResult_last = array_pop($arrFile_ar);
        if ($arResult_last['amount'] != $arrResult['amount'] ) {
            array_push($arrFile_ar, $arrResult);
            $arrFile_json = json_encode($arrFile_ar);
            file_put_contents($file, $arrFile_json);
            PR($arrFile_json);
        } else {
            echo 'No changes were detected';
        }
    }
} else {
    echo 'No connection';
}

//phpinfo();
function PR($o, $show = false) {
    global $USER;
        $bt = debug_backtrace();
        $bt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $bt["file"] = str_replace($dRoot, "", $bt["file"]);
        ?>
        <div style='font-size: 12px;font-family: monospace;width: 100%;color: #181819;background: #EDEEF8;border: 1px solid #006AC5;'>
            <div style='padding: 5px 10px;font-size: 10px;font-family: monospace;background: #006AC5;font-weight:bold;color: #fff;'>File: <?= $bt["file"] ?> [<?= $bt["line"] ?>]</div>
            <pre style='padding:10px;'><? print_r($o) ?></pre>
        </div>
        <?
}
?>