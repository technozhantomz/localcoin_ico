<?php
$CSVname1 = 'airdrop-users.csv';
$CSVname2 = 'sent.csv';

if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){
    $dataCsv1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' . $CSVname1);
} else {
    $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
    $dataCsv1 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' .$CSVname1);
}

if (isset($_SERVER['DOCUMENT_ROOT']) and !empty($_SERVER['DOCUMENT_ROOT'])){
    $dataCsv2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' . $CSVname2);
} else {
    $_SERVER['DOCUMENT_ROOT'] = getenv('MY_DOCUMENT_ROOT');
    $dataCsv2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/scripts//' .$CSVname2);
}

$arDataCsv1 = str_getcsv($dataCsv1, "\n");
foreach($arDataCsv1 as &$Row) $Row = str_getcsv($Row, ",");

$arDataCsv2 = str_getcsv($dataCsv2, "\n");
foreach($arDataCsv2 as &$Row) $Row = str_getcsv($Row, ",");

//pr($arDataCsv1);
//pr($arDataCsv2);

foreach($arDataCsv2 as $sent) {
    //pr($sent[0]);
    foreach($arDataCsv1 as $airdrop) {
        if($sent[0] == $airdrop[0]) echo $airdrop[0].'<br>';
    }
    //die;
}

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