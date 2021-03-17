<?php $locale     = 'sc' ?>
<?php $page_title = 'Member Home' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">个人主页</h1>
            <div id="regist_form">

                <div align="right">
                    <a href="/user/member/signoff"><span class="text14">| 离开 |</span></a>
                </div>
                <h2 class="mainTi">个人账号</h2>

                <table class="input_table">
                    <tr>
                        <th>会员 : </th>
                        <td>
                            <?php echo h($name); ?>
                        </td>
                    <tr>
                        <th>注册电子邮箱 : </th>
                        <td>
                            <?php echo h($mail); ?>
                        </td>
                    </tr>
                </table>
                <div class="active m30"><a href="/user/member/edit" class="aligncenter">确认登录</a></div>


                <div class="section">
                    <h2 class="mainTi">上传照片</h2>

                    <table class="uploadTable">
                        <tr>
                            <th>部门</th>
                            <?php foreach ($status as $categoryId => $stat): ?>
                            <td nowrap>
                                <?php echo h($stat['name']); ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>投稿</th>
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
                        点击数字后能确认投稿作品。
                    </div>

                    <div class="ate">
                        <p class="m10">已支付的可投稿照片数 :
                            <?php echo h($picturePurchased); ?>
                        </p>
                        <p class="m10">投稿照片数 :
                            <?php echo h($pictureEntered); ?>
                        </p>
                        <p class="m10">还可以投稿的照片数 :
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
                        <a href="/user/entry/entry" class="aligncenter">点击这点并上传照片</a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($usePaydollar): ?>
                <?php if ($inPay): ?>
                <!-- credit card -->

                <div class="section">
                    <h2 class="mainTi">支付</h2>

                    <img src="/assets/images/system/paydollar.gif" alt="pay dollar" class="photoL" />
                    <p class="m10">
                        PayDollar是2000年开始面向市场的大型、可信赖的，活跃在银行、在线贸易的国际支付业务服务终端。客户的支付明细采用256字节的扩展验证证书(EV)，将实时认证交易信息，安全地送达交易银行、银行卡及支付方。<br />
                        PayDpllar不仅查证CVV/CVC,还支持Master card的3D安全确认。
                        通过VISA/Maaster card的SecureCode,验证客户或商户两者追加的安全保护。</p>
                    <p class="disc">关于退费:<br />
                        除系统故障导致不能投稿外，支付完成后不能退款。<br />
                        上传照片有问题时,请与我们联系。<br />
                        <a href="mailto:support@naturesbestphotography.asia">support@naturesbestphotography.asia</a>
                    </p>




                    <ul class="creditList">
                        <li><img src="/assets/images/system/visa.jpg" alt="visa" /></li>
                        <li><img src="/assets/images/system/master.jpg" alt="master" /></li>
                        <li><img src="/assets/images/system/unionpay.jpg" alt="Union Pay" /></li>
                    </ul>

                    <p class="bold center">合计金额: $(USD)
                        <?php echo h($paymentAmount); ?> (照片
                        <?php echo h($picturePackage); ?> 张)</p>

                    <form name="payFormCcard" method="post" action="<?php echo h($paymentEndpoint); ?>">

                        <input type="hidden" name="orderRef" value="<?php echo h($orderRef); ?>">
                        <input type="hidden" name="mpsMode" value="NIL">
                        <input type="hidden" name="currCode" value="<?php echo h($paymentCurrency); ?>">
                        <input type="hidden" name="amount" value="<?php echo h($paymentAmount); ?>">
                        <input type="hidden" name="lang" value="X">
                        <input type="hidden" name="cancelUrl" value="<?php echo h($paymentCancelUrl); ?>">
                        <input type="hidden" name="failUrl" value="<?php echo h($paymentFailUrl); ?>">
                        <input type="hidden" name="successUrl" value="<?php echo h($paymentSuccessUrl); ?>">
                        <input type="hidden" name="merchantId" value="<?php echo h($paymentMerchantId); ?>">
                        <input type="hidden" name="payType" value="N">
                        <input type="hidden" name="payMethod" value="CC">

                        <input type="submit" name="submit" value="支付" class="submitBtn aligncenter">

                    </form>

                </div>
                <!-- /credit card -->
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($usePaypal): ?>
                <?php if ($inPay): ?>
                <!-- PayPal -->

                <div class="section">
                    <h2 class="mainTi">支付</h2>

                    <p class="center"><input type="checkbox" id="imyouth" onclick="checkYouth()"> 我是未成年人。</p>
                    <p class="center">少年组的投稿作品上传时，请在类别选择栏选【少年组】。</p>

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

                    <p class="bold center">合计金额: $(USD) <span id="paypal_amount">
                            <?php echo h($paymentAmount); ?></span> (照片
                        <?php echo h($picturePackage); ?> 张)</p>

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