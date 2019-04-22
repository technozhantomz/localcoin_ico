<?
if ($_SERVER['REQUEST_URI'] == "/") {
    define('ISMAIN', true );
}

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

//PR($_SERVER);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Localcoin</title>
    <!-- CSS-->
    <link href="/css/style.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="wrapper">
      <header class="header <?=($_SERVER['REQUEST_URI'] != "/")?'header_inner':''?>" id="header">
        <div class="container">
          <div class="hamburger hamburger--squeeze">
            <div class="hamburger-box">
              <div class="hamburger-inner"></div>
            </div>
          </div><a class="header__logo" href="/"><img src="/img/logo.png" srcset="/img/logo-2x.png 2x" alt="Localcoin"></a>
          <div class="header__nav" style="display:none">
            <ul>
              <li><a href="#advantages">Why</a></li>
              <li><a href="#trading">Trading</a></li>
              <li><a href="#tokeninfo">Token info</a></li>
              <li><a href="#roadmap">Road map</a></li>
              <li><a href="#download">Download</a></li>
            </ul>
          </div>
          <div class="header__right-menu">
            <ul>
              <li><a class="btn-blue btn-blue_small" id="buy_coin_header" href="#">Buy LLC</a></li>
              <li><a class="btn-blue btn-blue_small sign-in" id="signIn" href="#download">Registrer</a></li>
              <li><a class="whitepaper" href="https://localcoin.is/downloads/LocalCoinBlockchain.pdf" target="_blank">WP</a></li>
              <li><a class="whitelabel" href="/whitelabel">WL</a></li>
              <li>
                <!-- <div class="header__lang select select-lang">
                  <input class="select_hidden" type="hidden" value="1">
                  <div class="select_in select-lang_in"><span class="select_title select-lang_title"><img src="img/eng.png" srcset="img/eng-2x.png 2x" alt="eng"></span><i class="select_arrow select-lang_arrow"></i></div>
                  <ul class="select_list select-lang_list">
                    <li class="is-active" data-value="1"><img src="img/eng.png" srcset="img/eng-2x.png 2x" alt="eng"></li>
                    <li data-value="2"><img src="img/svg/rus.svg" alt="rus"></li>
                  </ul>
                </div> -->
              </li>
            </ul>
          </div>
        </div>
      </header>
