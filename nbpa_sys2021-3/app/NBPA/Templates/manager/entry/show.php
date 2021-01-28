<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/entry/index?c=<?php echo h($c); ?>&amp;q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>">Entries</a></li>
                <li>ID: <?php echo h($entry->regist_apply_no); ?></li>
            </ol>
        </div><!-- /row -->

        <div class="row">
            <div class="col-sm-8 col-md-9">
                <!-- command -->
                <div class="row">
                    <div class="well well-sm">
                        <a href="/manager/entry/edit/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>?c=<?php echo h($c); ?>&amp;q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    </div>
                </div>

<?php if (isset($flash['errors'])): ?>
                <div class="row">
                    <div class="alert alert-danger">
                        <?php echo h($flash['errors']); ?>
                    </div>
                </div>
<?php endif; ?>
<?php if (isset($flash['message'])): ?>
                <div class="row">
                    <div class="alert alert-info">
                        <?php echo h($flash['message']); ?>
                    </div>
                </div>
<?php endif; ?>

<?php if (!empty($entry)): ?>
<?php
foreach ($categories as $categoryCode => $categoryName) {
    if ($entry->apply_genre == $categoryCode) {
        $entry->category = $categoryName;
        break;
    }
}
?>

                <div class="row">
                    <table class="table table-striped table-hover -table-condensed">
                        <colgroup>
                            <col class="col-xs-3">
                            <col class="col-xs-9">
                        </colgroup>
                        <tr>
                            <th class="text-nowrap">ID</th>
                            <td class="text-nowrap"><?php echo h($entry->regist_apply_no); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Category</th>
                            <td class="text-nowrap"><?php echo h($entry->category); ?></td>
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
                                <a class="image-link" href="/manager/entry/image/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>">
                                    <img src="/manager/entry/thumbnail/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" width="160">
                                </a>
                            </td>
<?php endif; ?>
                        </tr>
<?php if ($entry->apply_genre != 6): ?>
                        <tr>
                            <th></th>
                            <td>
                                <p><a href="/manager/entry/download/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">Download</a></p>
                            </td>
                        </tr>
<?php endif; ?>
                        <tr>
                            <th class="text-nowrap">Title</th>
                            <td class="text-nowrap"><?php echo h($entry->image_title); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Member ID</th>
                            <td class="text-nowrap"><?php echo h($entry->member_regist_no); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Member name</th>
                            <td class="text-nowrap"><?php echo h($member->name_m); ?> <?php echo h($member->name_s); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Judge status</th>
                            <td class="text-nowrap">
<?php
$judgeStatus = '';
if ($entry->judge_status == 0) {
    $judgeStatus = '-';
} elseif ($entry->judge_status == 2) {
    $judgeStatus = '1st approved';
} elseif ($entry->judge_status == 4) {
    $judgeStatus = '2nd approved';
} elseif ($entry->judge_status == 6) {
    $judgeStatus = 'semi final approved';
} elseif ($entry->judge_status > 6) {
    $stats = [];
    if ($entry->judge_status & 0x10) {
        $stats[] = 'UPS';
    } elseif ($entry->judge_status & 0x20) {
        $stats[] = 'Category';
    } elseif ($entry->judge_status & 0x40) {
        $stats[] = 'Smithonian';
    }
    $judgeStatus = implode(', ', $stats);
}
?>
<?php echo h($judgeStatus); ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-nowrap bg-info">Staff comment</th>
                            <td class="bg-info"><?php echo nl2br(h($entry->staff_comment)); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">High resolution photo</th>
                            <td class="text-nowrap"><?php echo h($entry->highres_photo_name); ?></td>
                        </tr>
<?php if (!empty($entry->highres_photo_name)): ?>
                        <tr>
                            <th></th>
                            <td>
                                <p><a href="/manager/entry/hiresdownload/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">Download</a></p>
                            </td>
                        </tr>
<?php endif; ?>
                        <tr>
                            <th class="text-nowrap">RAW file</th>
                            <td class="text-nowrap"><?php echo h($entry->raw_file); ?></td>
                        </tr>
<?php if (!empty($entry->raw_file)): ?>
                        <tr>
                            <th></th>
                            <td>
                                <p><a href="/manager/entry/rawdownload/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">Download</a></p>
                            </td>
                        </tr>
<?php endif; ?>
                        <tr>
                            <th class="text-nowrap">Location</th>
                            <td class="text-nowrap"><?php echo h($entry->photo_place); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Camera model</th>
                            <td class="text-nowrap"><?php echo h($entry->camera); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Lens model</th>
                            <td class="text-nowrap"><?php echo h($entry->lens); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Shutter speed</th>
                            <td class="text-nowrap"><?php echo h($entry->ss); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">F-number</th>
                            <td class="text-nowrap"><?php echo h($entry->f_num); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Film speed (ISO)</th>
                            <td class="text-nowrap"><?php echo h($entry->iso); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Flash model</th>
                            <td class="text-nowrap"><?php echo h($entry->flash); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Tripod</th>
                            <td class="text-nowrap"><?php echo h($entry->tripod); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Comment</th>
                            <td><?php echo nl2br(h($entry->photo_comment)); ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Entried at</th>
                            <td class="text-nowrap"><?php echo h($entry->entry_date); ?></td>
                        </tr>
                    </table>
                </div>

<?php endif; ?>

            </div>
        </div>
    </div><!-- /container -->

<script>
$(document).ready(function() {
    $('.image-link').magnificPopup({
        type: 'image'
    });
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
