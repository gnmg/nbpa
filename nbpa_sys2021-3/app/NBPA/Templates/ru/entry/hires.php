<?php $locale     = 'ru' ?>
<?php $page_title = 'Hires' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Загрузить фотографию в хорошем качестве</h1>
            <div id="regist_form">

                <!-- Entry form -->
                <form id="frm_entry" method="post" action="/user/entry/hires" enctype="multipart/form-data">
                    <input type="hidden" name="t" value="<?php echo h($t); ?>">
                    <input type="hidden" name="id" value="<?php echo h($id); ?>">

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

                    <table class="input_table">
                        <tr>
                            <th><label>Категория</label></th>
                            <td>
                                <?php foreach ($categories as $categoryId => $categoryName): ?>
                                <?php if ($entry->apply_genre == $categoryId): ?>
                                <?php echo h($categoryName); ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Название</label></th>
                            <td>
                                <?php echo h($entry->image_title); ?>
                            </td>
                        </tr>
                        <?php if ($entry->apply_genre == 6): ?>
                        <tr>
                            <th><label>Видео</label></th>
                            <td>
                                <?php
echo $entry->apply_image;
?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th><label>Фото</label></th>
                            <td>
                                <img src="/user/entry/image/<?php echo h($entry->regist_apply_no); ?>" width="240">
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><label>Файл в высоком разрешении</label> <span class="required">*</span></th>
                            <td>
                                <input type="file" name="hrimage" value="">
                                <p>Создайте КОПИИ ваших исходных изображений как 16 битный RGB TIFF с высоким
                                    разрешением (от 300 до 400 точек на дюйм).</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>RAW файл</label></th>
                            <td>
                                <input type="file" name="rawfile" value="">
                                <p>RAW или оригинальный файл.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Место съёмки</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="location" value="<?php echo h($entry->photo_place); ?>"
                                    maxlength="128" size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Модель камеры</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="cmodel" value="<?php echo h($entry->camera); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Модель объектива</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="lmodel" value="<?php echo h($entry->lens); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        </tr>
                        <tr>
                            <th><label>Вытержка</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="sspeed" value="<?php echo h($entry->ss); ?>" maxlength="32"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Относительное отверстие объектива</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="fnum" value="<?php echo h($entry->f_num); ?>" maxlength="16"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Светочувствительность фотоматериала</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="fspeed" value="<?php echo h($entry->iso); ?>" maxlength="32"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Вспышка</label></th>
                            <td>
                                <input type="text" name="fmodel" value="<?php echo h($entry->flash); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Штатив</label></th>
                            <td>
                                <input type="text" name="tmodel" value="<?php echo h($entry->tripod); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Комментарий</label> <span class="required">*</span></th>
                            <td>
                                <textarea name="comment" rows="5" cols="40"><?php echo h($entry->photo_comment); ?></textarea>
                            </td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Назад" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Отправить" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>