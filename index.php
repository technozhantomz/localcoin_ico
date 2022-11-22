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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133419070-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-133419070-3');
</script>      
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HOMEPESA SOCIETY">
    <title>Hpesa is the true democratic decentralized ecosystem.</title>
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
          </div><a class="header__logo" href="/"><img src="/img/logo.png" srcset="/img/logo-2x.png 2x" alt="Homepesa"></a>
          <div class="header__nav" style="display:none">
            <ul>
              <li><a href="#advantages">Why HomePesa</a></li>
              <li><a href="#trading">Transaction Fees</a></li>
            </ul>
          </div>
          <div class="header__right-menu">
            <ul>
              <li><a class="btn-blue btn-blue_small" onclick="gtag('event', 'buy', {'event_category': 'header'});" id="" href="https://nft.homepesa.org">NFTs</a></li>
              <li><a class="btn-blue btn-blue_small sign-in" id="" href="https://sacco.homepesa.org/">Register</a></li>
              <li><a class="whitepaper" href="https://soko.homepesa.org/#" target="_blank">eCommerce</a></li>
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

<section class="main" id="main">
        <div class="main__bg">
          <video preload="auto" autoplay loop muted tabindex="0">
            <source src="img/main_bg.png" type="video/mp4">
          </video>
        </div>
        <div class="container">
          <div class="main__tab-links tab-links">
            <ul>
              <li><a class="gradient-text active" href="#preSale">Services</a></li>
              <li><a class="gradient-text" href="#airDrop">Offer</a></li>
            </ul>
          </div>
          <div class="main__tab active" id="preSale">
            <div class="pre-sale">
              <div class="ps-circuit">
                <div class="ps-coin-hover"><a class="btn-yellow" onclick="gtag('event', 'buy', {'event_category': 'coin-btn'});" href="#" id="coin_hover_btn">Fund Account</a></div>
                <div class="pre-sale__slider-wrap">
                  <div class="pre-sale__slider">
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_01 item-hover" href="#">
                        <div class="item-img item-img_01"><img src="img/icons/pre-sale_ico1.png" srcset="img/icons/pre-sale_ico1-2x.png 2x" alt="icon1"></div>
                        <h4>Decentralized <br>sacco</h4>
                        <div class="item-desc">
                          <h4>Decentralized <br>sacco</h4>
                          <p>No one can block your wallet.Its a Multisignature (multisig) accounts.</p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_02 item-hover" href="#">
                        <div class="item-img item-img_02"><img src="img/icons/pre-sale_ico2.png" srcset="img/icons/pre-sale_ico2-2x.png 2x" alt="icon2"></div>
                        <h4>27000+ <br>Members</h4>
                        <div class="item-desc">
                          <h4>27000+ <br>Members</h4>
                          <p>Twiter, fb, etc</p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_03 item-hover" href="#">
                        <div class="item-img item-img_03"><img src="img/icons/pre-sale_ico3.png" srcset="img/icons/pre-sale_ico3-2x.png 2x" alt="icon3"></div>
                        <h4>Instant<br>Transaction</h4>
                        <div class="item-desc">
                          <h4>Instant<br>Transaction</h4>
                          <p>Over-the-counter (OTC) or off-exchange trading is done directly between two parties, without the supervision of an exchange. <span class="md-lg-hidden">It is contrasted with exchange trading, which occurs via exchanges. A stock exchange has the benefit of facilitating liquidity, providing transparency, and maintaining the current market price. In an OTC trade, the price is not necessarily published for the public.</span></p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_04 item-hover" href="#">
                        <div class="item-img item-img_04"><img src="img/icons/pre-sale_ico4.png" srcset="img/icons/pre-sale_ico4-2x.png 2x" alt="icon4"></div>
                        <h4>ICO<br>Accelerator</h4>
                        <div class="item-desc">
                          <h4>ICO<br>Accelerator</h4>
                          <p>Start your own ICO. You can issue your own token and list it for trading in just 5 min.</p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_05 item-hover" href="#">
                        <div class="item-img item-img_05"><img src="img/icons/pre-sale_ico5.png" srcset="img/icons/pre-sale_ico5-2x.png 2x" alt="icon5"></div>
                        <h4>Peer2Peer<br>Transactions</h4>
                        <div class="item-desc">
                          <h4>Peer2Peer<br>Transactions</h4>
                          <p>Your personal chain is encrypted and no-one can see your transactions.</p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_06 item-hover" href="#">
                        <div class="item-img item-img_06"><img src="img/icons/pre-sale_ico6.png" srcset="img/icons/pre-sale_ico6-2x.png 2x" alt="icon6"></div>
                        <h4>Main Currency</h4>
                        <div class="item-desc">
                          <h4>Main Currency</h4>
                          <p>Everyone can earn KES by running a Activenode to support the network(CommonCloud).</p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_07 item-hover" href="#">
                        <div class="item-img item-img_07"><img src="img/icons/pre-sale_ico7.png" srcset="img/icons/pre-sale_ico7-2x.png 2x" alt="icon7"></div>
                        <h4>Social<br>Network</h4>
                        <div class="item-desc">
                          <h4>Social<br>Network</h4>
                          <p>Blockchain based and fully encrypted decentralized Social network. <span class="md-lg-hidden">Forget about facebook, google or twitter tracking, blocking annoying ads. True democracy supported by blockchain network</span></p>
                        </div></a></div>
                    <div class="pre-sale__slide"><a class="ps-circuit__item ps-circuit__item_08 item-hover" href="#">
                        <div class="item-img item-img_08"><img src="img/icons/pre-sale_ico8.png" srcset="img/icons/pre-sale_ico8-2x.png 2x" alt="icon8"></div>
                        <h4>Decentralized<br>App</h4>
                        <div class="item-desc">
                          <h4>Decentralized<br>App</h4>
                          <p>From day one You can trade with others without limits. 100k Transaction per second. The Block is generated every 2 seconds.</p>
                        </div></a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="main__tab" id="airDrop">
            <div class="air-drop">
              <div class="row">
                <div class="col-md-6">
                  <div class="air-drop__left-block">
                    <h3 class="wow fadeInUp"><a href="https://t.me/HpEsa" target="_blank">Get you <span>first 5000 </span>KES for <span>free </span>NOW!</a></h3>
                    <p class="wow fadeInUp">To get the 5000/=, you need to <a href="https://sacco.homepesa.org" target="_blank">register here</a> and type your ACCOUNT NAME <a href="https://t.me/HpEsa" target="_blank">here</a>. Your wallet will be credited with 5000 KES via telegram API after the reservation is over.</p>
                    <div class="air-drop__chart-label wow fadeInUp"><span>0 </span>5000/= PROMO FUNDS</div>
                    <div class="air-drop__chart">
                      <div class="air-drop__chart-inner">
<div class="line-chart">
  <div class="aspect-ratio">
    <canvas id="chart"></canvas>
  </div>
</div>
                      </div>
                    </div>
                    <div class="air-drop__progress"><span class="s-left">0 MONEY PROMOTED</span>
                      <div class="air-drop__progress-bar"><span class="s-left s-black">0 KES PROMO SENT</span></div><span class="s-right">0 KES left</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="air-drop__right-block wow fadeInUp" data-wow-duration="1.5s">
                    <h3>Limited Offers</h3>
                    <h4>We will offer 10,000,000 KES</h4><span>to Telegram and Twitter users from 1st of December till the end of promotion Campaign</span>
                    <p>ON the 20th of Jan. 2023 It'll be announced enhanced Bounty program with Twitter and Telegram participation. All scores of Grand Promo will be saved and announced to participants.</p>
                    <div class="air-drop__reg-links"><a class="btn-yellow btn-yellow_small" href="https://t.me/HpEsa" target="_blank">Register now</a></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
        <section class="advantages" id="advantages">
      <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2"><a class="advantages__video" href="https://www.youtube.com/watch?v=XBKY4FWcl5M?autoplay=1" data-fancybox=""><img src="img/video_bg.png" alt="video">
                <h2 class="wow fadeInUp">Why Homepesa</h2></a></div>
          </div>
          <div class="advantages__table-wrap" style="padding-top: 25px;">
            <div class="advantages__table">
              <div class="advantages__table-inner">
                <table class="a-table-fixed">
                  <thead>
                    <tr>
                      <th style="width:22%"> </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/lc-logo.png" alt="logo"></div><span>homepesa.org</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/lbc-logo.png" alt="logo"></div><span>LocalBanks</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/gdax.png" alt="logo"></div><span>ZACCOZ</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/okex.png" alt="logo"></div><span>OKEx</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/bin.png" alt="logo"></div><span>Binance</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/bitf.png" alt="logo"></div><span>Bitfinex</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/huobi.png" alt="logo"></div><span>Huobi</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/hitbtc.png" alt="logo"></div><span>HitBTC</span>
                      </th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
                <table class="a-table">
                  <colgroup class="col-title"></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup></colgroup>
                  <colgroup class="col-empty"></colgroup>
                  <thead>
                    <tr>
                      <th style="width:22%"> </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/lc-logo.png" alt="logo"></div><span>homepesa.org</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/lbc-logo.png" alt="logo"></div><span>LocalBanks</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/gdax.png" alt="logo"></div><span>ZACCOZ</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/okex.png" alt="logo"></div><span>OKASH</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/bin.png" alt="logo"></div><span>Binance</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/bitf.png" alt="logo"></div><span>Bitfinex</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/huobi.png" alt="logo"></div><span>Huobi</span>
                      </th>
                      <th style="width:9%">
                        <div class="t-logo"><img src="img/hitbtc.png" alt="logo"></div><span>HitBTC</span>
                      </th>
                      <th> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left">Blockchain based platform</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Decentralization</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Anonymity</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">OTC (over the counter) Trading</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Cannot block your account</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">No coin listing approval</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">eWallet (Internal trasfers)</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">No account verification</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">No trading limits</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">No withdrawal limits</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">No account suspension</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Public reports</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Decentralized chat</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Untraceable transactions</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Mobile app</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Desktop app</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Transactions per second</td>
                      <td class="t-best">100k</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td class="t-na">n.a.</td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Fees</td>
                      <td class="t-best">Free</td>
                      <td>1%</td>
                      <td>0.50%</td>
                      <td>0.20%</td>
                      <td>0.10%</td>
                      <td>0.20%</td>
                      <td>0.20%</td>
                      <td>0.10%</td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Has been hacked before</td>
                      <td class="t-best">No</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td>Yes</td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Payment process
          </td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Social Networking</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Core Token</td>
                      <td class="t-best">KSH</td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td class="t-best">BTC</td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                    <tr>
                      <td class="text-left">Multi-signature account</td>
                      <td>
                        <div class="t-plus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td>
                        <div class="t-minus"></div>
                      </td>
                      <td> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="trading" id="trading">
        <div class="container">
          <h1 class="wow fadeInUp center">Homepesa Global Community</h1>
          <div class="row">
            <div class="col-md-6 offset-md-6">
              <div class="trading__item trading__item_02 wow fadeInUp">
                <h5>High performance</h5>
                <p>A Blockchain-based system that handles 100,000 transactions per second.</p>
              </div>
              <div class="trading__item trading__item_04 wow fadeInUp">
                <h5>Maximum security</h5>
                <p>Homepesa employess cannot have access to your account. Neither can it be hacked by experienced bank hackers, simply because it is only You who hold blockchain keys to it.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="getfree" id="getfree">
        <div class="container">
          <div class="getfree__logo"><img src="./../img/d-logo.png" srcset="./../img/d-logo-2x.png 2x" alt="logo"></div>
          <h2 class="wow fadeInUp">Fund <span>Your Account </span>NOW<span>!!!</span></h2>
          <p class="wow fadeInUp">The first 10,000 registerred ussers receive 1000 KES</p><a class="getfree__btn btn-yellow" href="https://t.me/HpEsa">Get IT NOW!</a>
        </div>
      </section>
      <footer class="footer" id="footer">
        <div class="container">
          <ul class="footer__social f-social">
            <li><a class="f-social__item f-social__item_tm" href="https://t.me/HpEsa" target="_blank"></a></li>
          </ul>
          <ul class="footer__links">
            <li><a class="btn-blue" onclick="gtag('event', 'buy', {'event_category': 'footer'});"  id="buy_coin_footer" href="#">Fund Account</a></li>
          </ul>
          <ul class="footer__nav wow fadeInUp">
            <li><a href="#main">Home</a></li>
            <li><a href="https://how.homepesa.org" target="_blank">User guide</a></li>
          </ul>
          <div class="footer__desc wow fadeInUp">Homepesa.org is THE true democracy decentralised ecosystem, Homepesa is a society (community) of people who are tired of the tradition banking bureaucracy</div>
        </div>
      </footer>
      <div class="popup-modal">
        <div class="p-modal">
          <div class="p-modal__close"></div>
          <div class="p-modal__form" id="bridgeFormInput">
            <form class="ps-form" action="#" id="bridgeForm">
              <div class="ps-form__input ps-form__input_num input-coin">
                <input type="number" min="0.0001" step="0.0001" name="btc" value="0" id="bridgeAmountFrom">
                <div class="ps-form__select select select-coin">
                  <input class="select_hidden" type="hidden" value="USD" id="bridgeCurrency">
                  <div class="select_in select-coin_in">
                    <span class="select_title select-coin_title" id="bridgeCurrenciesLabel">USD</span>
                    <i class="select_arrow select-coin_arrow"></i>
                  </div>
                  <div class="select_list select-coin_list" id="bridgeCurrenciesList">
                    <div class="search_container">
                      <input type="text" id="search_input" placeholder="Search..">
                    </div>
                  </div>
                </div>
                <div class="prev-coin"></div>
                <div class="next-coin"></div>
              </div>
              <div class="ps-form__arr"></div>
              <div class="ps-form__input ps-form__input_num input-llc">
                <input type="number" name="kes" value="0" id="bridgeAmountTo" style="background-color: #fff;">
                <label id="bridgeAmountToError" style="display: none; display: block; position: relative; float: left; top: 50px; color: #ffde25; font-size: 16px;">minimum is 500 KES</label>
              </div>
              <div class="ps-form__input ps-form__input_text" style="margin-top: 30px;">
                <input type="text" id="grapheneUsername" placeholder="Your HomePesa Account name">
                <span id="loginError" class="ps-form__reg" style="color: #faa; display: inherit; margin-top: 10px;"></span>
                <span class="ps-form__reg">Not a member yet? <a href="https://sacco.homepesa.org" target="_blank">Register now</a></span>
              </div>
              <input class="ps-form__btn btn-yellow" type="submit" value="Fund KES" id="bridgeSubmit">
            </form>
          </div>
          <div class="p-modal__form" id="bridgeFormAddress" style="display: none;">
            <span class="ps-form__reg" style="display: inherit; margin-top: 20px;">Deposit to account: <a id="accountName" target="_blank" href=""></a></span>
            <span class="ps-form__reg" style="display: inherit; margin-top: 20px;">Address for deposit <a id="bridgeFormInputAsset" target="_blank" href=""></a>: </span>
            <span class="ps-form__reg" style="display: inherit; font-size: 20px;">
            <textarea rows="3" id="bridgeFormInputAddress" style="margin-top: 10px; width: 450px; border: 0; background: none; color: #fff; text-align: center; font-size: 19px;"></textarea>
            </span>
            <span class="ps-form__reg">
              <a data-copy="#bridgeFormInputAddress" style="font-size: 25px; cursor: pointer;">copy address</a>
            </span>
            <span id="bridgeFormInputCountConfirmations" class="ps-form__reg" style="display: inherit; margin-top: 10px;"></span>
            <span id="loginError" class="ps-form__reg" style="color: #faa; display: inherit; margin-top: 10px; padding-left: 25px; padding-right: 25px; margin-top: 10px;">
              IMPORTANT: Send only  to this deposit address. Sending less than or any other currency to this address may result in the loss of your deposit.
            </span>
          </div>
        </div>
      </div>
    </div>

    <input type="hidden" id="translate-count-confirmations" value="Wait for {x} confirmations for balance funding"      />
    <input type="hidden" id="translate-course-error-load"   value="Exchange rate update failed, please reload the page" />
    <input type="hidden" id="translate-login-error"         value="The account name could not be found"                 />
    <input type="hidden" id="translate-emptylogin-error"    value="Please enter real account name"                      />

    <!-- jQuery-->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <!-- Plugins for airDrop chart-->
    <script src="/js/TweenMax.min.js"></script>
    <script src="/js/Draggable.min.js"></script>
    <script src="/js/ThrowPropsPlugin.min.js"></script>
    <script src="/js/DrawSVGPlugin.min.js"></script>
    <script src="/js/AnticipateEase.min.js"></script>
    <script src="/js/MorphSVGPlugin.min.js"></script>
    <!-- Plugins-->
    <script src="/js/wow.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/fancybox.min.js"></script>
    <script src="/js/mCustomScrollbar.min.js"></script>
    <script src="/js/Chart.min.js"></script>
    <script src="/js/chartjs-plugin-style.min.js"></script>
    <script src="/js/Sticky-kit.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- JavaScripts-->
    <script src="/js/scripts.js"></script>
    <script src="/js/bridge.js"></script>
  </body>
</html>

