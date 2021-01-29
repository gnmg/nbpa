<?php $locale     = 'ko' ?>
<?php $page_title = 'Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">사진 업로드</h1>
            <div id="regist_form">

                <!-- Entry form -->
                <form id="frm_entry" method="post" action="/user/entry/entry" enctype="multipart/form-data">
                    <input type="hidden" name="_METHOD" value="PUT">
                    <input type="hidden" name="t" value="<?php echo h($t); ?>">

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
                            <th><label>부문:</label></th>
                            <td>
                                <?php foreach ($categories as $categoryId => $categoryName): ?>
                                <?php if ($category == $categoryId): ?>
                                <?php echo h($categoryName); ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>타이틀:</label></th>
                            <td>
                                <?php echo h($title); ?>
                            </td>
                        </tr>
                        <?php if ($category == 6): ?>
                        <tr>
                            <th><label>Movie:</label></th>
                            <td>
                                <?php echo $embedcode; ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th><label>사진:</label></th>
                            <td><img src="/user/entry/image/temporary?t=<?php echo h($t); ?>" width="640"></td>
                        </tr>
                        <?php endif; ?>
                    </table>


                    <ul class="submitList">
                        <li><input type="submit" name="back" value="돌아가기" class="backBtn"></li>
                        <li><input type="submit" name="entry" value="입고" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>