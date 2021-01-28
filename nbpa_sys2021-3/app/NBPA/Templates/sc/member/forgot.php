<?php $locale     = 'sc' ?>
<?php $page_title = 'Forgot Password' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">忘记密码</h1>
            <div align="center">
                <p class="tex14">请输入电子信箱<br />
                    登录地址已发送至电子信箱<br />
                    点击邮件中的登录地址设定密码<br /></p>
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
                            <th>电子邮件地址</th>
                            <td><input type="text" id="mail" name="mail" value="" placeholder="E-mail" class="formText"></td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="返回" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="确认" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Login form -->

            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>