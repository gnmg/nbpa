<?php $locale     = 'en' ?>
<?php $page_title = 'Member Home' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Your Account</h1>
            <div id="regist_form">

                <div align="right">
                    <a href="/user/member/signoff"><span class="text14">| Log Out |</span></a>
                </div>
                <h2 class="mainTi">Your Account</h2>

                <table class="input_table">
                    <tr>
                        <th>Member: </th>
                        <td>
                            <?php echo h($name); ?>
                        </td>
                    <tr>
                        <th>Registered e-mail address: </th>
                        <td>
                            <?php echo h($mail); ?>
                        </td>
                    </tr>
                </table>
                <div class="active m30"><a href="/user/member/edit" class="aligncenter">Change your information</a>
                </div>


                <div class="section">
                    <h2 class="mainTi">Upload Images</h2>

                    <table class="uploadTable">
                        <tr>
                            <th>Category</th>
                            <?php foreach ($status as $categoryId => $stat): ?>
                            <td nowrap>
                                <?php echo h($stat['name']); ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>Images Entered</th>
                            <?php foreach ($status as $categoryId => $stat): ?>
                            <?php if ($stat['entered_count'] > 0): ?>
                            <td><a href="/user/entry/list/<?php echo h($categoryId); ?>">
                                    <?php echo h($stat['entered_count']); ?></a></td>
                            <?php else: ?>
                            <td>
                                <?php echo h($stat['entered_count']); ?>
                            </td>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </table>

                    <div class="imgTi5">
                        Click the number under each category to see the images entered for that category.
                    </div>

                    <div class="ate">
                        <p class="m10">Number of entries paid for:
                            <?php echo h($picturePurchased); ?>
                        </p>
                        <p class="m10">Number of images you have entered:
                            <?php echo h($pictureEntered); ?>
                        </p>
                        <p class="m10">Number of remaining images to enter:
                            <?php echo h($picturePurchased - $pictureEntered); ?>
                        </p>
                    </div>


                    <!-- Error Messages -->
                    <?php if (isset($flash['error'])): ?>
                    <div>
                        <ul class="confirm_red m10" style="list-style:none;">
                            <?php $errors = $flash['error']; ?>
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
                        <a href="/user/entry/entry" class="aligncenter">Click here to upload images</a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($usePaydollar): ?>
                <?php if ($inPay): ?>
                <!-- credit card -->

                <div class="section">
                    <h2 class="mainTi">Payment</h2>

                    <img src="/assets/images/system/paydollar.gif" alt="pay dollar" class="photoL" />
                    <p class="m10">PayDollar is a leading, secure and reliable international payment service provider
                        to banks and online merchants since 2000. Customers' payment details are securely transmitted
                        to the acquiring bank, card and payment companies for real-time transaction authorisation using
                        256-bit Extended Validation Certificates (EV) SSL transaction encryption.<br />
                        PayDollar supports CVV/CVC check as well as 3-D secure authentication of Visa and MasterCard
                        namely:
                        Verified By VISA, MasterCard SecureCode for added security protection for both customers and
                        merchant. </p>
                    <p class="disc">Refund Policy:<br />
                        Once you complete the payment, there will be no refund unless you couldn't submit the pictures
                        because of a system error.
                        Please contact us if you have any problem uploading images. support@naturesbestphotography.asia</p>




                    <ul class="creditList">
                        <li><img src="/assets/images/system/visa.jpg" alt="visa" /></li>
                        <li><img src="/assets/images/system/master.jpg" alt="master" /></li>
                        <li><img src="/assets/images/system/unionpay.jpg" alt="Union Pay" /></li>
                    </ul>

                    <p class="bold center">Total Amount Due: USD $
                        <?php echo h($paymentAmount); ?> (
                        <?php echo h($picturePackage); ?> pictures)</p>

                    <form name="payFormCcard" method="post" action="<?php echo h($paymentEndpoint); ?>">

                        <input type="hidden" name="orderRef" value="<?php echo h($orderRef); ?>">
                        <input type="hidden" name="mpsMode" value="NIL">
                        <input type="hidden" name="currCode" value="<?php echo h($paymentCurrency); ?>">
                        <input type="hidden" name="amount" value="<?php echo h($paymentAmount); ?>">
                        <input type="hidden" name="lang" value="E">
                        <input type="hidden" name="cancelUrl" value="<?php echo h($paymentCancelUrl); ?>">
                        <input type="hidden" name="failUrl" value="<?php echo h($paymentFailUrl); ?>">
                        <input type="hidden" name="successUrl" value="<?php echo h($paymentSuccessUrl); ?>">
                        <input type="hidden" name="merchantId" value="<?php echo h($paymentMerchantId); ?>">
                        <input type="hidden" name="payType" value="N">
                        <input type="hidden" name="payMethod" value="CC">

                        <input type="submit" name="submit" value="Purchase" class="submitBtn aligncenter">

                    </form>

                </div>
                <!-- /credit card -->
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($usePaypal): ?>
                <?php if ($inPay): ?>
                <!-- PayPal -->

<h2 class="mainTi">Payment</h2>
<p class="center">To enter this years contest please click on the Make Payment button below. You will then be taken to our payment page.</p>
<p class="center">After you have finished your payment there will be a link to click to come back to this page to upload your images.</p>
<p class="center" style="color:red">If you do not see the upload button then please reload the page and it should appear.</p>
<p class="center" style="color:red">If you have any problems please send us an email ad support@naturesbestphotography.asia and we will help you.</p>


<p class="bold center">Total Amount: USD $<span id="paypal_amount">
                            <?php echo h($paymentAmount); ?></span> (
                        <?php echo h($picturePackage); ?> pictures )</p>
                        
                        <p class="center" style="color:red">If you would like to pay with another credit card besides Visa or Master Card please send us an email at support@naturesbestphotography.asia</p>



<!--<div class="text-center col-md-12"><a href="https://payhere.co/j-start/nbpa-entry-fee" data-payhere-embed="https://payhere.co/j-start/nbpa-entry-fee" class="button-pay">Make Payment</a>
<script src="https://payhere.co/embed/embed.js"></script></script>-->

<!-- BEGIN STRIPE PAYMENT -->
<div class="text-center col-md-12" style="margin-top: 30px;">
    <form action="/user/stripe/payment" method="post">
        <noscript>You must <a href="http://www.enable-javascript.com" target="_blank">enable JavaScript</a> in your web browser in order to pay via Stripe.</noscript>

    <button class="mt-3 button-pay w-100" type="submit" value="Pay with Card" ¨ data-key="pk_live_rwNss9zszWNtjrrOaxfVPcsc00CSTGEF9z" data-amount="2500" data-currency="usd" data-name="NBPA" data-description="NBPA Entry Fee, USD $25">
	<strong>Make Payment</strong>
     </button>
     <!-- <button class="mt-3 button-pay w-100" type="submit" value="Pay with Card" ¨ data-key="pk_test_nmOldG4IF92gor5DUMY73RVU00kAOwO8Tq" data-amount="2500" data-currency="usd" data-name="NBPA" data-description="NBPA Entry Fee, USD $25">
	<strong>Make Payment</strong>
     </button> -->

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





                <!--<div class="section">
                    <h2 class="mainTi">Payment</h2>

                    <p class="center"><input type="checkbox" id="imyouth" onclick="checkYouth()"> Junior Category: Click
                        Here ($15 USD)</p>
                    <p class="center">Please select the Junior Category to enter all Junior Category photos.</p>

                    <script>
                    function checkYouth() {
                        var chk = document.getElementById('imyouth');
                        if (chk.checked != true) {
                            document.getElementById('hosted_button_id').value = "ZHGMSA8S8ABJG";
                            document.getElementById('paypal_amount').innerText = "<?php echo h($paymentAmount); ?>";
                            document.getElementById('gmoAmount').value = "<?php echo h($paymentAmount); ?>";
                            document.getElementById('gmoShopPass').value = "<?php echo h($gmoShopPass); ?>";
                        } else {
                            document.getElementById('hosted_button_id').value = "SXS9AYBRVQTJ4";
                            document.getElementById('paypal_amount').innerText =
                                "<?php echo h($paymentAmountYouth); ?>";
                            document.getElementById('gmoAmount').value = "<?php echo h($paymentAmountYouth); ?>";
                            document.getElementById('gmoShopPass').value = "<?php echo h($gmoShopPassYouth); ?>";
                        }
                    }
                    </script>

                    <p class="bold center">Total Amount Due: USD $<span id="paypal_amount">
                            <?php echo h($paymentAmount); ?></span> (
                        <?php echo h($picturePackage); ?> pictures )</p>

                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" id="hosted_button_id" value="ZHGMSA8S8ABJG">
                        <input type="image" src="https://naturesbestphotography.asia/assets/images/paypal_cards.png"
                            border="0" name="submit" alt="Buy Now!" class="aligncenter">
                        <img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1"
                            height="1">
                        <input type="hidden" name="invoice" value="<?php echo h($orderRef); ?>">
                    </form>

                </div>
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
                    <input type="hidden" name="Lang" value="en">
                    <input type="hidden" name="Enc" value="utf-8">
                    <input type="hidden" name="Confirm" value="1">
                    <input type="image" src="/assets/images/gmopg_cards.png" border="0" name="submit"
                        class="aligncenter">
                </form>

                <!-- /GMO PG -->
                <?php endif; ?>
                <?php endif; ?>

            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>