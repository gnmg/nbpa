<?php $locale     = 'ko' ?>
<?php $page_title = 'Log on' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">로그인</h1>
            <p>마이페이지로의 액세스는 여기</p>

            <div id="regist_form">
                <table class="loginTable">
                    <tr>
                        <td class="left">
                            <div><a href="/user/member/forgot"><span class="logonBtn">비밀번호를 잊으신 분은 여기</span></a></div>
                            <div><a href="/user/member/signup"><span class="logonBtn">신규등록은 여기에서</span></a></div>
                        </td>
                        <td class="right">

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

                            <!-- Login form -->
                            <form id="frm_login" method="post" action="/user/member/logon">
                                <div><input type="text" class="input_boxstyle" id="user_id" name="user_id" value=""
                                        placeholder="E-mail"></div>
                                <div><input type="password" class="input_boxstyle" id="password" name="password" value=""
                                        placeholder="Password"></div>
                                <div><input type="checkbox" id="eternal_login" name="eternal_login"><span class="input_table_p">로그인
                                        상태를 유지</span></div>
                                <div id="mail_send_btn"><input type="submit" value="로그인" class="loginBtn"></div>
                            </form><!-- /Login form -->

                        </td>
                    </tr>
                </table>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>