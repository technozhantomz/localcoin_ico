<?php
/*
+ Пишем функцию подключения к CURL и отправки POST-запросов в формате json.
+ Пишем функцию которая на входе принимает название функции и массив параметров, пробрасывает их в массив и выдаёт на выходе готовый к отправке json. В ответе возвращает массив.
+ Пишем запрос на fixer который возвращает массив курсов по всем ассетам, что у них есть к USD.
+ Забираем массив смарт-ассеты из файла и формируем из них массив к публикации фидов
+ Обогащаем массив смарт-ассетов, добавляя каждому ассету его курс к LLC в отношении 1 USD = 2 LLC и не забываем про precision (5 у core, 6 у smartassets)
- Создаем массив публичных-ключей витнесов
Забираем с cliwallet ключи через dump_private_key и проверяем с теми что уже загружены в wallet. Если каких-то ключей не хватает, выводим ошибку.
Создаем цикл прогона массива всех смарт-ассетов с курсами под каждого витнеса добавленного в массив. Выводим на фронт инфу что обновили и у кого.

TODO
Повесить скрипт на крон на каждую минуту, проверять у смартассетов дату окончания фидов и если время <1 часа, то запускать скрипт обновления.
Собрать простенький интерфейс
Написать логгирование скрипта в файл
*/

//Конфиг
$fixerKey = '3d412586b14709b75ef2cb90703cac8a';
$CSVname = 'smartlist.csv';
$arWitnessess = [
    'adamgottie' => 'LLC8hVi9DP17ctdfTG8zPDNmLSWD6CYmKa9Sfj22edfA3ges9hBq9',
    'winstonsmith' => 'LLC816R4zNkroH66rMXdrwcGUySEctRUVMj5XzAGSpmy7upoTPGBK',
    'julia' => 'LLC7d9NC2zoPX7zpvS3XbrZba8vu7LxihVPxSwnuDohfUYVvgRLKy',
    'obrien' => 'LLC8S3q6334wRthZRnR31cbUiJ1PfVESTvGT9uCkjud9pFFYRpB5E',
    'aaronson' => 'LLC5SV5jZKp6pLv1MFdtyo5edLfaRvg3uCR1m3r8tVtMbBDFPwoQA',
    'ampleforth' => 'LLC8ZJTY1YRbkjFxmv5EzvAHwgDifDkGiuYYCbyYede89jw25abW8',
    'charrington' => 'LLC7VmmoqLA9zMW6mzMSuV8TCQ7C1jGFsnDrEx5HUvBuqWqRjs7P5'                            
];
$walletPass = 'KarvrEHcP6';

function sendCurl(string $method, $arParams = [''], $ignoreErr = true) {

    $curl = curl_init("http://localhost:8091/"); //подключаемся к локальному кошельку

    $data = [
        "jsonrpc" => "2.0", 
        "id" => 1, 
        "method" => $method,
        "params" => $arParams
    ];


    $data_json = json_encode($data);//заворачиваем в json

    //PR($data_json);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);//шлём POST с инфой
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//забираем ответ в теле

    $result = curl_exec($curl);
    curl_close($curl);

    $arResult = json_decode($result, true);
    if (isset($arResult) and !empty($arResult)) {
        if (isset($arResult['error']['message']) and !empty($arResult['error']['message'])) {
            if ($ignoreErr != true) {
                die('Stopped with error: <b>' . $arResult['error']['message'] . '</b>');
            } else {
                //PR($arResult['error']['message']);
            }
        } else {
            return $arResult['result'];
            //PR($arResult);
        }
    } else {
        die('Lost connection to the CLI wallet');
    }
    //PR($arResult);
}


function getExRates() { //Получаем массив рейтов по каждому смарт-ассету с фиксера

    global $fixerKey, $CSVname;

    $curl = curl_init("https://data.fixer.io/api/latest?access_key=" . $fixerKey . "&base=USD"); //Забираем курсы с fixer
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//забираем ответ в теле

    $result = curl_exec($curl);
    curl_close($curl);

    $arResult = json_decode($result, true);
    //PR($arResult);
    if (isset($arResult) and !empty($arResult)) {
        if (isset($arResult['error']) and !empty($arResult['error'])) {
            die('Stopped with error: <b>' . $arResult['error'] . '</b>');
        } else {
            $arRates = $arResult['rates'];
        }
    } else {
        die('Lost connection to the Fixer');
    }

    if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){//Читаем файл смартассетов, определяем переменную для крона
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' . $CSVname);
    } else {
        $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
        $dataCsv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' .$CSVname);
    }
    $arDataCsv = array_flip(str_getcsv($dataCsv, "\n"));

    //форич массива CSV, используя значения массива CSV находим в массиве с фиксера такие же ключи и при нахождении сохраняем в новый массив вместе с курсом
    foreach (array_keys($arDataCsv) as $key) {
        if(empty($arRates[$key])) {
            continue;
        } 
        $arDataCsv[$key] = intval(($arRates[$key])*1000000);// 1LLC =0.5USD * 1 000 000 precision смарт-ассетов
    }
    pr($arDataCsv);
    return $arDataCsv;
}

function get_asset($asset_symbol){
    $arResult = sendCurl('get_asset', [$asset_symbol]);
    return $arResult['id'];
}

function get_account_id($account_name){
    $arResult = sendCurl('get_account_id', [$account_name]);
    return $arResult;
}

//$getExRates = getExRates();
//PR($getExRates);

function updateFeeds(){

    global $walletPass, $arWitnessess;

    if (sendCurl('is_locked') == '1') { // Не залочен ли
        sendCurl('unlock', [$walletPass]);
    }

    $arPrivkeys = sendCurl('dump_private_keys'); // Сверяем все ли ключи на месте
    foreach($arPrivkeys as $value) {
        $arPubkeys []= $value[0];
    }

    $i = 0;
    foreach ($arWitnessess as $value) {
        $check = array_key_exists($value, array_flip($arPubkeys));
        if (!$check) {
            die('Check your config, wallet doesn\'t have enought keys.');
        }
    }

    $getExRates = getExRates();
    //PR($getExRates);
    foreach ($arWitnessess as $key => $value) {

        $witness_id = get_account_id($key);

        foreach($getExRates as $symbol => $rate){

            $symbol_id = get_asset($symbol);

            $curl_data = [
                '0' => $witness_id,//нужны функция получания id паблишеров по имени
                '1' => $symbol_id,//нужна функция получания id ассета по имени
                [
                    'settlement_price' => [
                        'base' => [
                                'amount' => $rate,//курс
                                'asset_id' => $symbol_id,//айди id asseta
                        ],
                        'quote' => [
                                'amount' => 100000,
                                'asset_id' => '1.3.0',
                        ],
                    ], 
                    'maintenance_collateral_ratio' => 1750,
                    'maximum_short_squeeze_ratio' => 1200,
                    'core_exchange_rate' => [
                        'base' => [
                            'amount' => $rate,//курс
                            'asset_id' => $symbol_id,//айди id asseta
                            ],
                        'quote' => [
                            'amount' => 100000,
                            'asset_id' => '1.3.0',
                        ],
                    ],
                ],
                '3' => "true"
            ];
            sendCurl('publish_asset_feed', $curl_data); //отправляем инфу по ассету
            //PR($curl_data);
//            die();
        }
    }
}

updateFeeds();

//PR(sendCurl('is_locked'));// 1
//PR(sendCurl('unlock', ['351003'])); 2
//PR(sendCurl('dump_private_keys')); 3
//PR(array_keys($getExRates)); foreach передавая ключи в метод ниже
//PR(sendCurl('get_asset', ['CNY'])); ['id'] и ['bitasset_data_id']
//PR(sendCurl('get_object', ['2.4.26'])); ['feeds']['4']['1']['0'] дата обновления фида
//PR(sendCurl('publish_asset_feed', $feedUpdate));

/*
{
  "jsonrpc": "2.0",
  "id": 1,
  "method": "publish_asset_feed",
  "params": [
    "Name",
    "asset'",
    {
      "settlement_price": {
        "base": {
          "amount": "",
          "asset_id": ""
        },
        "quote": {
          "amount": "",
          "asset_id": "1.3.0"
        }
      },
      "maintenance_collateral_ratio": 1750,
      "maximum_short_squeeze_ratio": 1200,
      "core_exchange_rate": {
        "base": {
          "amount": "",
          "asset_id": ""
        },
        "quote": {
          "amount": "",
          "asset_id": "1.3.0"
        }
      }
    },
    "true"
  ]
}
*/

//debug script
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