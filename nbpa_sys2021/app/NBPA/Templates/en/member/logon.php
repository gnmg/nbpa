<?php $locale     = 'en' ?>
<?php $page_title = 'Log on' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">Log In</h1>
            <!-- <p>Access your account to upload, add favorites, comment and curate.</p> -->
            <p style="color:red;">System is now closed for entries.</br></br><a href='mailto: support@naturesbestphotography.asia'>support@naturesbestphotography.asia</a></p>
            <div id="regist_form">
                <table class="loginTable">
                    <tr>
                        <td class="left">
                            <div><a href="/user/member/forgot"><span class="logonBtn">Forgot password?</span></a></div>
                            <div><a href="/user/member/signup"><span class="logonBtn">No account? Sign Up!</span></a></div>
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
                            <!-- <form id="frm_login" method="post" action="/user/member/logon">
                                <div><input type="text" class="input_boxstyle" id="user_id" name="user_id" value=""
                                        placeholder="E-mail"></div>
                                <div><input type="password" class="input_boxstyle" id="password" name="password" value=""
                                        placeholder="Password"></div>
                                <div><input type="checkbox" id="eternal_login" name="eternal_login"><span class="input_table_p">Stay
                                        Logged in.</span></div>
                                <div id="mail_send_btn"><input type="submit" value="Login" class="loginBtn"></div>
                            </form> -->
                            <!-- /Login form -->

                        </td>
                    </tr>
                </table>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>