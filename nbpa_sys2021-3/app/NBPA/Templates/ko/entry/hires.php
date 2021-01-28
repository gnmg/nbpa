<?php $locale     = 'ko' ?>
<?php $page_title = 'Hires' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Upload a high resolution photography</h1>
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
                                <img src="/user/entry/image/<?php echo h($entry->regist_apply_no); ?>" width="240">
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><label>High Res file</label> <span class="required">*</span></th>
                            <td>
                                <input type="file" name="hrimage" value="">
                                <p>Create COPIES of your original images as High-Resolution 16-bit RGB TIFF (300 to 400
                                    ppi).</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>RAW file</label></th>
                            <td>
                                <input type="file" name="rawfile" value="">
                                <p>RAW (or original) file.</p>
                            </td>
                        </tr>
                        <tr>
                            <th><label>Location</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="location" value="<?php echo h($entry->photo_place); ?>"
                                    maxlength="128" size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Camera model</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="cmodel" value="<?php echo h($entry->camera); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Lens model</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="lmodel" value="<?php echo h($entry->lens); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        </tr>
                        <tr>
                            <th><label>Shutter speed</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="sspeed" value="<?php echo h($entry->ss); ?>" maxlength="32"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>F-number</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="fnum" value="<?php echo h($entry->f_num); ?>" maxlength="16"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Film speed (ISO)</label> <span class="required">*</span></th>
                            <td>
                                <input type="text" name="fspeed" value="<?php echo h($entry->iso); ?>" maxlength="32"
                                    size="10">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Flash Model</label></th>
                            <td>
                                <input type="text" name="fmodel" value="<?php echo h($entry->flash); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Tripod Model</label></th>
                            <td>
                                <input type="text" name="tmodel" value="<?php echo h($entry->tripod); ?>" maxlength="64"
                                    size="40">
                            </td>
                        </tr>
                        <tr>
                            <th><label>Comment</label> <span class="required">*</span></th>
                            <td>
                                <textarea name="comment" rows="5" cols="40"><?php echo h($entry->photo_comment); ?></textarea>
                            </td>
                        </tr>
                    </table>

                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Back" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Confirmation" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Entry form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>