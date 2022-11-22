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
          <div class="footer__desc wow fadeInUp">Homepesa.org is THE true democracy decentralized ecosystem, Homepesa is not a person, it is a community of people who are tired of the tradition banking bureaucracy</div>
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
                <span class="ps-form__reg">Not a member yet? <a href="https://kenya.commodity.llc" target="_blank">Register now</a></span>
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
