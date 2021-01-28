<?php $locale     = 'ja' ?>
<?php $page_title = 'Hires Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Upload a high resolution photography</h1>
            <div id="regist_form">

                <!-- Entry form -->
                <form id="frm_entry" method="post" action="/user/entry/hires" enctype="multipart/form-data">
                    <input type="hidden" name="_METHOD" value="PUT">
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
                            <th><label>Category</label></th>
                            <td>
                                <?php foreach ($categories as $categoryId => $categoryName): ?>
                                <?php if ($entry->apply_genre == $categoryId): ?>
                                <?php echo h($categoryName); ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Title</label></th>
                            <td>
                                <?php echo h($entry->image_title); ?>
                            </td>
                        </tr>
                        <?php if ($entry->apply_genre == 6): ?>
                        <tr>
                            <th><label>Movie</label></th>
                            <td>
                                <?php
echo $entry->apply_image;
?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th><label>Photo</label></th>
                            <td>
                                <img src="/user/entry/image/<?php echo h($entry->regist_apply_no); ?>" width="480">
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><label>High Res file</label></th>
                            <td>
                                <?php echo h($imgOrig); ?> (
                                <?php echo h(number_format($imgSize)); ?> bytes)
                            </td>
                        </tr>
                        <tr>
                            <th><label>RAW file</label></th>
                            <td>
                                <?php if ($rawOrig != '' && $rawSize != 0): ?>
                                <?php echo h($rawOrig); ?> (
                                <?php echo h(number_format($rawSize)); ?> bytes)
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Location</label></th>
                            <td>
                                <?php echo h($entry->photo_place); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Camera model</label></th>
                            <td>
                                <?php echo h($entry->camera); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Lens model</label></th>
                            <td>
                                <?php echo h($entry->lens); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Shutter speed</label></th>
                            <td>
                                <?php echo h($entry->ss); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>F-number</label></th>
                            <td>
                                <?php echo h($entry->f_num); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Film speed (ISO)</label></th>
                            <td>
                                <?php echo h($entry->iso); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Flash Model</label></th>
                            <td>
                                <?php echo h($entry->flash); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Tripod Model</label></th>
                            <td>
                                <?php echo h($entry->tripod); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Comment</label></th>
                            <td>
                                <?php echo h($entry->photo_comment); ?>
                            </td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Back" class="backBtn"></li>
                        <li><input type="submit" name="entry" value="Entry" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>