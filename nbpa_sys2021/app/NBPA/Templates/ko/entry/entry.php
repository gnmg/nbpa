<?php $locale     = 'ko' ?>
<?php $page_title = 'Entry' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">사진 업로드</h1>
            <div id="regist_form">

                <!-- Entry form -->
                <form id="frm_entry" method="post" action="/user/entry/entry" enctype="multipart/form-data">
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
                            <th><label>부문</label></th>
                            <td><select id="selcat" name="category" onchange="selCat(this)">
                                    <?php foreach ($categories as $categoryId => $categoryName): ?>
                                    <?php if ($category == $categoryId): ?>
                                    <option value="<?php echo h($categoryId); ?>" selected>
                                        <?php echo h($categoryName); ?>
                                    </option>
                                    <?php else: ?>
                                    <option value="<?php echo h($categoryId); ?>">
                                        <?php echo h($categoryName); ?>
                                    </option>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <p>Please select the Junior Category to enter all Junior Category photos.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>타이틀</label></th>
                            <td><input type="text" id="title" name="title" value="<?php echo h($title); ?>"></td>
                        </tr>
                        <tr id="frmPhoto">
                            <th><label>사진</label></th>
                            <td><input type="file" id="filename" name="filename" accept="image/*;capture=camera"
                                    value="<?php echo h($filename); ?>">
                                <p>저해상도 JPEG(72ppi) 500K이하의 카피를 만들어 입고해 주세요.</p>
                            </td>
                        </tr>
                        <tr id="frmMovie" style="display:none">
                            <th><label>Movie</label></th>
                            <td><input type="text" id="embedcode" name="embedcode" value="<?php echo h($embedcode); ?>">
                                <p>Paste iframe embed code of YouTube/Vimeo video.<br />
                                    동영상길이를5분이내로제한해주세요.</p>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" id="agreement" name="agreement" value="1">

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="돌아가기" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="확인" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<script>
function selCat(s) {
    if (s.value == 6) { // Movie
        document.getElementById('frmPhoto').style.display = "none";
        document.getElementById('frmMovie').style.display = "";
    } else { // Other
        document.getElementById('frmPhoto').style.display = "";
        document.getElementById('frmMovie').style.display = "none";
    }
}
document.getElementById('selcat').onchange();
</script>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>