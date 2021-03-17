<?php $locale     = 'ja' ?>
<?php $page_title = '会員ホーム' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>


<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">マイページ</h1>
            <div id="regist_form">

                <div align="right">
                    <a href="/user/member/signoff"><span class="text14">| ログアウト |</span></a>
                </div>
                <h2 class="mainTi">マイページ</h2>

                <table class="input_table">
                    <tr>
                        <th>会員 : </th>
                        <td>
                            <?php echo h($name); ?>
                        </td>
                    <tr>
                        <th>登録しているメールアドレス : </th>
                        <td>
                            <?php echo h($mail); ?>
                        </td>
                    </tr>
                </table>
                <div class="active m30"><a href="/user/member/edit" class="aligncenter">会員登録情報変更</a>
                </div>

                <div class="section">
                    <h2 class="mainTi">写真をアップロード</h2>

                    <table class="uploadTable">
                        <tr>
                            <th>部門</th>
                            <?php foreach ($status as $categoryId=> $stat): ?>
                            <td nowrap>
                                <?php echo h($stat[ 'name']); ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>入稿</th>
                            <?php foreach ($status as $categoryId=> $stat): ?>
                            <?php if ($stat[ 'entered_count'] > 0): ?>
                            <td>
                                <a href="/user/entry/list/<?php echo h($categoryId); ?>">
                                    <?php echo h($stat[ 'entered_count']); ?>
                                </a>
                            </td>
                            <?php else: ?>
                            <td>
                                <?php echo h($stat[ 'entered_count']); ?>
                            </td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </table>

                    <div class="imgTi5">
                        数字をクリックすると入稿した作品を確認できます。
                    </div>

                    <div class="ate">
                        <p class="m10">支払われた入稿可能写真数 :
                            <?php echo h($picturePurchased); ?>
                        </p>
                        <p class="m10">入稿写真数 :
                            <?php echo h($pictureEntered); ?>
                        </p>
                        <p class="m10">まだ入稿可能な写真数 :
                            <?php echo h($picturePurchased - $pictureEntered); ?>
                        </p>
                    </div>


                    <!-- Error Messages -->
                    <?php if (isset($flash[ 'error'])): ?>
                    <div>
                        <ul class="confirm_red m10" style="list-style:none;">
                            <?php $errors=$flash['error']; ?>
                            <?php foreach ($errors as $error): ?>
                            <li>
                                <?php echo h($error); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if ($inTerm): ?>
                    <div class="submitBtn2 m30">
                        <a href="/user/entry/entry" class="aligncenter">アップロード</a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($usePaydollar): ?>
                <?php if ($inPay): ?>
                <!-- credit card -->

                <div class="section">
                    <h2 class="mainTi">支払い</h2>

                    <img src="/assets/images/system/paydollar.gif" alt="pay dollar" class="photoL" />
                    <p class="m10">PayDollarは、2000年より大手安全で信頼できる、銀行、オンラインビジネス用の国際的支払いサービスプロバイダです。顧客の支払い詳細は256ビットの拡張検証証明書（
                        EV）SSLトランザクションの暗号化を使用してリアルタイムの取引認証のための承継銀行、カード、支払会社に安全に送信されます。
                        <br /> PayDollarはCVV / CVCチェックだけでなくビザとマスターカードの3-Dセキュア認証をサポートしています。
                        <br /> 顧客や商人両者の追加セキュリティ保護をVISA ／マスターカードのSecureCodeによって検証します。</p>
                    <p class="disc">返金について:
                        <br /> システムエラーにより入稿出来ない場合を除いては支払い完了後は返金はいたしかねます。
                        <br /> 写真のアップロードに問題がある場合はご連絡下さい。
                        <br />
                        <a href="mailto:support@naturesbestphotography.asia">support@naturesbestphotography.asia</a>
                    </p>




                    <ul class="creditList">
                        <li><img src="/assets/images/system/visa.jpg" alt="visa" />
                        </li>
                        <li><img src="/assets/images/system/master.jpg" alt="master" />
                        </li>
                        <li><img src="/assets/images/system/unionpay.jpg" alt="Union Pay" />
                        </li>
                    </ul>

                    <p class="bold center">合計金額: $
                        <?php echo h($paymentAmount); ?>USD (写真
                        <?php echo h($picturePackage); ?> 枚)</p>

                    <form name="payFormCcard" method="post" action="<?php echo h($paymentEndpoint); ?>">

                        <input type="hidden" name="orderRef" value="<?php echo h($orderRef); ?>">
                        <input type="hidden" name="mpsMode" value="NIL">
                        <input type="hidden" name="currCode" value="<?php echo h($paymentCurrency); ?>">
                        <input type="hidden" name="amount" value="<?php echo h($paymentAmount); ?>">
                        <input type="hidden" name="lang" value="J">
                        <input type="hidden" name="cancelUrl" value="<?php echo h($paymentCancelUrl); ?>">
                        <input type="hidden" name="failUrl" value="<?php echo h($paymentFailUrl); ?>">
                        <input type="hidden" name="successUrl" value="<?php echo h($paymentSuccessUrl); ?>">
                        <input type="hidden" name="merchantId" value="<?php echo h($paymentMerchantId); ?>">
                        <input type="hidden" name="payType" value="N">
                        <input type="hidden" name="payMethod" value="CC">

                        <input type="submit" name="submit" value="購入する" class="submitBtn aligncenter">

                    </form>

                </div>
                <!-- /credit card -->
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($usePaypal): ?>
                <?php if ($inPay): ?>
                <!-- PayPal -->
<h2 class="mainTi">お支払</h2> 
<p class="">応募するには下記の【お支払】をクリックしてください。</p> 
<p class="">お支払い後にアップロードするためのリンクがありますので、クリックするとこの応募画面に戻ります。</p> 
<p class="" style="color:red">もしアップロードするボタンが画面上に出ない場合は、ページの更新（リフレッシュ）をしてください。</p> 
<p class="" style="color:red">ご不明な点がございましたら　support@naturesbestphotography.asia　までお問い合わせください。すぐに対応させていただきます。</p>

<p class="bold center">参考金額: USD $<span id="paypal_amount">
                            <?php echo h($paymentAmount); ?></span> (
                        <?php echo h($picturePackage); ?> 写真 )</p>
                        <p class="bold center"style="color:red">お支払いはVISAかマスターカードがご利用いただけます。
その他のカードでにお支払いをご希望の際にはメールにて事務局までご連絡下さい。インボイス(ご請求書)をお送りしお支払いいただく事が出来ます。support@naturesbestphotography.asia</p>
                        
                        
                        <!-- BEGIN STRIPE PAYMENT -->
<div class="text-center col-md-12" style="margin-top: 30px;">
    <form action="/user/stripe/payment" method="post">
        <noscript>You must <a href="http://www.enable-javascript.com" target="_blank">enable JavaScript</a> in your web browser in order to pay via Stripe.</noscript>

    <button class="mt-3 button-pay w-100" type="submit" value="Pay with Card" ¨ data-key="pk_live_rwNss9zszWNtjrrOaxfVPcsc00CSTGEF9z" data-amount="2500" data-currency="usd" data-name="NBPA" data-locale="auto" data-description="NBPA Entry Fee, USD $25">
	<strong>お支払</strong>
     </button>

    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $(':submit').on('click', function(event) {
                event.preventDefault();

                var $button = $(this),
                    $form = $button.parents('form');

                var opts = $.extend({}, $button.data(), {
                    token: function(result) {
                        $form.append($('<input>').attr({
                            type: 'hidden',
                            name: 'stripeToken',
                            value: result.id
                        })).submit();
                    }
                });

                StripeCheckout.open(opts);
            });
        });
    </script>
  </form>
</div>
<!-- END STRIPE PAYMENT -->

                        
                        

<!--<div class="text-center col-md-12"><a href="https://payhere.co/j-start/nbpa-entry-fee" data-payhere-embed="https://payhere.co/j-start/nbpa-entry-fee" class="button-pay">Make Payment</a>
<script src="https://payhere.co/embed/embed.js"></script></script> -->



                <!-- <div class="section">
                    <h2 class="mainTi">支払い</h2>

                   <p class="center"><input type="checkbox" id="imyouth" onclick="checkYouth()"> ジュニア部門応募者はこちらをクリック
                        ($15 USD)</p>
                    <p class="center">ジュニア部門の応募はアップロードする際、全て『ジュニア』枠を選択して入稿して下さい</p>

                    <script>
                    function checkYouth() {
                        var chk = document.getElementById('imyouth');
                        if (chk.checked != true) {
                            document.getElementById('hosted_button_id').value = "ZHGMSA8S8ABJG";
                            document.getElementById('paypal_amount').innerText = "<?php echo h($paymentAmount); ?>";
                            document.getElementById('paypal_jpy').innerText =
                                "<?php echo h(round($paymentAmount * $usdjpy)); ?>";
                            document.getElementById('gmoAmount').value = "<?php echo h($paymentAmount); ?>";
                            document.getElementById('gmoShopPass').value = "<?php echo h($gmoShopPass); ?>";
                        } else {
                            document.getElementById('hosted_button_id').value = "SXS9AYBRVQTJ4";
                            document.getElementById('paypal_amount').innerText =
                                "<?php echo h($paymentAmountYouth); ?>";
                            document.getElementById('paypal_jpy').innerText =
                                "<?php echo h(round($paymentAmountYouth * $usdjpy)); ?>";
                            document.getElementById('gmoAmount').value = "<?php echo h($paymentAmountYouth); ?>";
                            document.getElementById('gmoShopPass').value = "<?php echo h($gmoShopPassYouth); ?>";
                        }
                    }
                    </script>-->

                    
                    <!--<p class="center">参考金額：
                        <span id="paypal_jpy"><?php echo h(round($paymentAmount * $usdjpy)); ?></span>円
                        (<?php echo h($rateDate); ?> レート)<br>
                        ※カード利用金額ご請求時の為替レートで決済金額が確定されますのでご了承下さい。</p><br>

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" id="hosted_button_id" value="ZHGMSA8S8ABJG">
                        <input type="image" src="https://naturesbestphotography.asia/assets/images/paypal_cards.png"
                            border="0" name="submit" alt="Buy Now!" class="aligncenter">
                        <img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1"
                            height="1">
                        <input type="hidden" name="invoice" value="<?php echo h($orderRef); ?>">
                    </form>

                </div>-->
                <!-- /PayPal -->
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($useGmoPg): ?>
                <?php if ($inPay): ?>
                <!-- GMO PG -->

                <form method="post" action="<?php echo h($gmoEntryUrl); ?>">
                    <input type="hidden" name="ShopID" value="<?php echo h($gmoShopId); ?>">
                    <input type="hidden" name="OrderID" value="<?php echo h($gmoOrderRef); ?>">
                    <input type="hidden" name="Amount" id="gmoAmount" value="<?php echo h($paymentAmount); ?>">
                    <input type="hidden" name="Currency" value="USD">
                    <input type="hidden" name="DateTime" value="<?php echo h($gmoDatetime); ?>">
                    <input type="hidden" name="ShopPassString" id="gmoShopPass" value="<?php echo h($gmoShopPass); ?>">
                    <input type="hidden" name="RetURL" value="<?php echo h($gmoResultUrl); ?>">
                    <input type="hidden" name="CancelURL" value="<?php echo h($paymentCancelUrl); ?>">
                    <input type="hidden" name="UseCredit" value="1">
                    <input type="hidden" name="UseMcp" value="1">
                    <input type="hidden" name="JobCd" value="CAPTURE">
                    <input type="hidden" name="ClientField1" value="<?php echo h($orderRef); ?>">
                    <input type="hidden" name="Lang" value="ja">
                    <input type="hidden" name="Enc" value="utf-8">
                    <input type="hidden" name="Confirm" value="1">
                    <input type="image" src="/assets/images/gmopg_cards.png" border="0" name="submit"
                        class="aligncenter">
                </form>

                <!-- /GMO PG -->
                <?php endif; ?>
                <?php endif; ?>

            </div>
            <!-- regist_form END -->
        </div>
        <!-- contant END -->
    </div>
    <!-- container END -->

</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>