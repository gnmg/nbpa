<?php $locale     = 'ru' ?>
<?php $page_title = 'Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Регистрация. Проверка данных</h1>
            <div id="regist_form">
                <!-- Signup form -->
                <form id="frm_signup" method="post" action="/user/member/signup">
                    <input type="hidden" name="_METHOD" value="PUT">

                    <table class="input_table">
                        <tr>
                            <th>Электронная почта</th>
                            <td>
                                <?php echo h($mail); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Имя</th>
                            <td>
                                <?php echo h($name_f); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Фамилия</th>
                            <td>
                                <?php echo h($name_l); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Адрес</th>
                            <td>
                                <?php echo h($addr); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Индекс</th>
                            <td>
                                <?php echo h($zipcode); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Страна</th>
                            <td>
                                <?php foreach ($countries as $key => $val): ?>
                                <?php if ($key == $country): ?>
                                <?php echo h($val); ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Телефон</th>
                            <td>
                                <?php echo h($tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <?php echo h($mb_tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Пароль</th>
                            <td>
                                <?php echo h($password); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Ваш пол</th>
                            <td>
                                <?php if ($gender == 1): ?>
                                Женщина
                                <?php elseif ($gender == 2): ?>
                                Мужчина
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if (isset($promo_code)): ?>
                        <tr>
                            <th>Промокод</th>
                            <td>
                                <?php echo h($promo_code); ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Как вы узнали о нас?</th>
                            <td>
                                <ul>
                                    <?php foreach ($enquetes as $key => $val): ?>
                                    <?php if (in_array($key, $enquete)): ?>
                                    <li>
                                        <?php echo h($val); ?>
                                    </li>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Назад" class="backBtn"></li>
                        <li><input type="submit" name="send" value="Отправить" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Signup form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>