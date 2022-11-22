<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function pr($o, $show = false) {
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