<?php $locale     = 'ko' ?>
<?php $page_title = 'Member Home' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">마이페이지</h1>
            <div id="regist_form">

                <div align="right">
                    <a href="/user/member/signoff"><span class="text14">| 사인오프 |</span></a>
                </div>
                <h2 class="mainTi">마이페이지</h2>

                <table class="input_table">
                    <tr>
                        <th>회원 : </th>
                        <td>
                            <?php echo h($name); ?>
                        </td>
                    <tr>
                        <th>메일 주소를 등록 : </th>
                        <td>
                            <?php echo h($mail); ?>
                        </td>
                    </tr>
                </table>
                <div class="active m30"><a href="/user/member/edit" class="aligncenter">회원등록정보 변경</a></div>


                <div class="section">
                    <h2 class="mainTi">사진 업로드</h2>

                    <table class="uploadTable">
                        <tr>
                            <th>부문</th>
                            <?php foreach ($status as $categoryId => $stat): ?>
                            <td nowrap>
                                <?php echo h($stat['name']); ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>입고</th>
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
                        숫자를 클릭하면 입고된 작품을 확인할 수 있습니다.
                    </div>

                    <div class="ate">
                        <p class="m10">지불된 입고가능 사진수 :
                            <?php echo h($picturePurchased); ?>
                        </p>
                        <p class="m10">입고 사진수 :
                            <?php echo h($pictureEntered); ?>
                        </p>
                        <p class="m10">아직 입고가능한 사진수 :
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
                        <a href="/user/entry/entry" class="aligncenter">사진 업로드</a>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($usePaydollar): ?>
                <?php if ($inPay): ?>
                <!-- credit card -->

                <div class="section">
                    <h2 class="mainTi">지불</h2>

                    <img src="/assets/images/system/paydollar.gif" alt="pay dollar" class="photoL" />
                    <p class="m10">PayDollar는 2000년부터 안전하고 신뢰할 수 있는 대형 은행, 온라인 비즈니스용의 국제적 지불 서비스 프로바이더입니다. 고객의 지불 상세는
                        256비트의 확장검증증명서(EV) SSL 트랜잭션의 암호화를 사용하여 실시간 거래인증을 위한 계승은행, 카드, 지불회사로 안전하게 전송됩니다.<br />
                        PayDollar는 CVV/CVC 체크뿐 아니라 비자와 마스터카드의 3-D 시큐어 인증을 지원하고 있습니다.<br />
                        고객과 상인 양자의 추가 시큐리티 보호를 VISA/마스터카드의 SecureCode로 검증합니다. </p>
                    <p class="disc">환불:<br />
                        시스템 에러로 입고할 수 없는 경우를 제외하고 지불 완료 후에는 환불은 할 수 없습니다.<br />
                        사진 업로드에 문제가 있을 경우 연락해 주세요.<br />
                        <a href="mailto:info@naturebestphotography.asia">info@naturebestphotography.asia</a>
                    </p>




                    <ul class="creditList">
                        <li><img src="/assets/images/system/visa.jpg" alt="visa" /></li>
                        <li><img src="/assets/images/system/master.jpg" alt="master" /></li>
                        <li><img src="/assets/images/system/unionpay.jpg" alt="Union Pay" /></li>
                    </ul>

                    <p class="bold center">합계금액: $(USD)
                        <?php echo h($paymentAmount); ?> (사진
                        <?php echo h($picturePackage); ?> 점)</p>

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

                        <input type="submit" name="submit" value="구입" class="submitBtn aligncenter">

                    </form>

                </div>
                <!-- /credit card -->
                <?php endif; ?>
                <?php endif; ?>

                <?php if ($usePaypal): ?>
                <?php if ($inPay): ?>
                <!-- PayPal -->

                <div class="section">
                    <h2 class="mainTi">지불</h2>

                    <p class="center"><input type="checkbox" id="imyouth" onclick="checkYouth()"> 나는 미성년자입니다.</p>
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

                    <p class="bold center">합계금액: $(USD) <span id="paypal_amount">
                            <?php echo h($paymentAmount); ?></span> (사진
                        <?php echo h($picturePackage); ?> 점)</p>

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