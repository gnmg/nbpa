<?php $locale     = 'ko' ?>
<?php $page_title = 'List' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">

            <div id="regist_form">
                <!-- Entry form -->
                <form id="frm_entry" method="post" action="/user/entry/list/<?php echo h($category); ?>">

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


                    <h3 class="mainTi"><label>부문:</label>

                        <?php foreach ($categories as $categoryId => $categoryName): ?>
                        <?php if ($category == $categoryId): ?>
                        <?php echo h($categoryName); ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </h3>
                    <table class="input_table">
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <th class="noborder" colspan="2">
                                <h4 class="mainTi">
                                    <?php echo h($item->image_title); ?>
                                </h4>
                                <?php if ($category == 6): ?>
                                <?php echo $item->apply_image; ?>
                                <?php else: ?>
                                <img src="/user/entry/image/<?php echo h($item->regist_apply_no); ?>" width="690"></td>
                                <?php endif; ?>
                        </tr>
                        <?php if ($inTerm): ?>
                        <tr>
                            <th colspan="2">
                                <input type="checkbox" name="drops[]" value="<?php echo h($item->regist_apply_no); ?>">
                                삭제할 경우는 클릭해 주세요.</th>
                        </tr>
                        <?php endif; ?>
                        <?php if ($item->judge_status == 4): ?>
                        <tr>
                            <th colspan="2">
                                <a href="/user/entry/hires/<?php echo h($item->regist_apply_no); ?>">PASSED</a>
                            </th>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </table>



                    <ul class="submitList">
                        <li><input type="submit" name="back" value="돌아가기" class="backBtn"></li>
                        <?php if ($inTerm): ?>
                        <li><input type="submit" name="drop" value="삭제" class="submitBtn"></li>
                        <?php endif; ?>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>