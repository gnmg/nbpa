<?php $locale     = 'ru' ?>
<?php $page_title = 'Edit Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Редактировать информацию</h1>
            <div id="regist_form">



                <!-- Edit form -->
                <form id="frm_edit" method="post" action="/user/member/edit">
                    <input type="hidden" name="_METHOD" value="PUT">

                    <table class="input_table">
                        <tr>
                            <th>Электронный адрес</th>
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
                            <th>Адресс</th>
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
                            <th>Мобильный телефон</th>
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
                            <th>Пол</th>
                            <td>
                                <?php if ($gender == 1): ?>
                                Женщина
                                <?php elseif ($gender == 2): ?>
                                Мужчина
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Как вы узнали про нас?</th>
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
                        <li><input type="submit" name="update" value="Обновить" class="submitBtn"></li>
                    </ul>
                </form>
                <!-- /Edit form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>