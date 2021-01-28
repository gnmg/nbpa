<?php $locale     = 'en' ?>
<?php $page_title = 'Forgot Password' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Forgot your password?</h1>
            <div align="center">
                <p class="tex14">Enter your registered mail address.<br />
                    You’ll receive an e-mail to your registered e-mail address.<br />
                    You can set a new password by clicking the URL in your e-mail.<br /></p>
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
                            <th>E-mail</th>
                            <td><input type="text" id="mail" name="mail" value="" placeholder="E-mail" class="formText"></td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Back" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Confirmation" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Login form -->

            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>