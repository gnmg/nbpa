<?php $locale     = 'ru' ?>
<?php $page_title = 'Forgot Password' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Забыли пароль?</h1>
            <div align="center">
                <p class="tex14">Введите ваш электронный адрес, указанный при регистрации.<br />
                    Мы отправим вам письмо на этот адрес.<br />
                    Вы сможете установить новый пароль, перейдя по ссылке из письма.<br /></p>
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
                            <th>Электронный адрес</th>
                            <td><input type="text" id="mail" name="mail" value="" placeholder="E-mail" class="formText"></td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Назад" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Отправить" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Login form -->

            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>