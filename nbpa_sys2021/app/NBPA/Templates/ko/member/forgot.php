<?php $locale     = 'ko' ?>
<?php $page_title = 'Forgot Password' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">비밀번호를 잊으신 분은 여기</h1>
            <div align="center">
                <p class="tex14">등록 메일 주소를 입력<br />
                    등록 메일 주소로 메일을 송신합니다.<br />
                    메일 주소로 송신된 URL을 클릭하여 새로운 비밀번호를 설정합니다.<br /></p>
            </div>

            <div id="regist_form">
                <!-- Error Messages -->
                <?php if (isset($flash['error'])): ?>
                <div>
                    <ul>
                        <?php $errors = $flash['error']; ?>
                        <?php foreach ($errors as $error): ?>
                        <li>
                            <?php echo h($error); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>



                <form id="frm_forgot" method="post" action="/user/member/forgot">

                    <table class="input_table">
                        <tr>
                            <th>메일</th>
                            <td><input type="text" id="mail" name="mail" value="" placeholder="E-mail" class="formText"></td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="돌아가기" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="확인" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Login form -->

            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>