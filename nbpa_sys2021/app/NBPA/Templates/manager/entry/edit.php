<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/entry/index?c=<?php echo h($c); ?>&amp;q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>">Entries</a></li>
                <li>ID: <a href="/manager/entry/show/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>?c=<?php echo h($c); ?>&amp;q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>"><?php echo h($entry->regist_apply_no); ?></a></li>
            </ol>
        </div><!-- /row -->

        <div class="row">
            <div class="col-sm-8 col-md-9">

<?php if (isset($flash['errors'])): ?>
                <div class="row">
                    <div class="alert alert-danger">
                        <ul>
<?php foreach ($flash['errors'] as $error): ?>
                            <li><?php echo h($error); ?></li>
<?php endforeach; ?>
                        </ul>
                    </div>
                </div>
<?php endif; ?>

<?php if (!empty($entry)): ?>

                <form method="post" action="/manager/entry/edit">
                    <input type="hidden" name="uid" value="<?php echo h($entry->member_regist_no); ?>">
                    <input type="hidden" name="id" value="<?php echo h($entry->regist_apply_no); ?>">
                    <input type="hidden" name="q" value="<?php echo h($q); ?>">
                    <input type="hidden" name="c" value="<?php echo h($c); ?>">
                    <input type="hidden" name="page" value="<?php echo h($page); ?>">

                    <!-- command -->
                    <div class="row">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" name="action" value="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-striped table-hover -table-condensed">
                            <colgroup>
                                <col class="col-xs-3">
                                <col class="col-xs-9">
                            </colgroup>
                            <tr>
                                <th>ID</th>
                                <td><?php echo h($entry->regist_apply_no); ?></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Category</th>
                                <td class="text-nowrap">
                                    <select class="selectpicker" name="apply_genre">
<?php foreach ($categories as $categoryCode => $categoryName): ?>
<?php if ($entry->apply_genre == $categoryCode): ?>
                                        <option value="<?php echo h($categoryCode); ?>" selected><?php echo h($categoryName); ?></option>
<?php else: ?>
                                        <option value="<?php echo h($categoryCode); ?>"><?php echo h($categoryName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
<?php if ($entry->apply_genre == 6): ?>
                                <th class="text-nowrap">Movie</th>
                                <td>
<?php
$embedcode       = $entry->apply_image;
$small_embedcode = preg_replace(
    ['/width="\d+"/i', '/height="\d+"/i'],
    [sprintf('width="%d"', 160), sprintf('height="%d"', 90)],
    $embedcode
);
echo $small_embedcode;
?>
                                </td>
<?php else: ?>
                                <th class="text-nowrap">Photo</th>
                                <td class="text-nowrap">
                                    <img src="/manager/entry/thumbnail/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" width="160">
                                </td>
<?php endif; ?>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Title</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="image_title" value="<?php echo h($entry->image_title); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Judge status</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="judge_status" value="<?php echo h($entry->judge_status); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap bg-info">Staff comment</th>
                                <td class="bg-info">
                                    <textarea class="form-control" name="staff_comment"><?php echo h($entry->staff_comment); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Location</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="photo_place" value="<?php echo h($entry->photo_place); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Camera model</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="camera" value="<?php echo h($entry->camera); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Lens model</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="lens" value="<?php echo h($entry->lens); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Shutter speed</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="ss" value="<?php echo h($entry->ss); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">F-number</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="f_num" value="<?php echo h($entry->f_num); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Film speed (ISO)</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="iso" value="<?php echo h($entry->iso); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Flash model</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="flash" value="<?php echo h($entry->flash); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Tripod</th>
                                <td class="text-nowrap"><input type="text" class="form-control" name="tripod" value="<?php echo h($entry->tripod); ?>"></td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">Comment</th>
                                <td><textarea class="form-control" name="photo_comment"><?php echo h($entry->photo_comment); ?></textarea></td>
                            </tr>
                        </table>
                    </div>

                </form>

<?php endif; ?>

            </div>
        </div>
    </div><!-- /container -->

<script type="text/javascript">
$(document).ready(function(){
    $(".selectpicker").selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
