<?php $locale     = 'ru' ?>
<?php $page_title = 'Reset Password' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Изменить пароль</h1>
            <div id="regist_form">
                <p class="tex14">Введите новый пароль</p>

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

                <!-- reset form -->
                <form id="frm_resetpassword" method="post" action="/user/member/resetpassword">
                    <input type="hidden" name="mid" value="<?php echo h($mid); ?>">
                    <input type="hidden" name="t" value="<?php echo h($t); ?>">

                    <table class="input_table">
                        <tr>
                            <th><label>Пароль</label></th>
                            <td><input type="text" id="password" name="password" value=""></td>
                        </tr>
                        <tr>
                            <th><label>Подтвердите пароль</label></th>
                            <td><input type="text" id="password_chk" name="password_chk" value=""></td>
                        </tr>
                    </table>


                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Назад" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Изменить" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /reset form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>