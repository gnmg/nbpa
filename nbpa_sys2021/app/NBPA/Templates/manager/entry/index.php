<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/magnific-popup.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js"></script>
    <!-- picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li>Entries</li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- search -->
        <div class="row">
            <form method="get" action="/manager/entry/index">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-4">
                            <input type="search" class="form-control" id="q" name="q" value="<?php echo h($q); ?>" placeholder="Search keyword: Title, Member ID">
                        </div>
                        <select class="selectpicker" name="c">
                            <option value="0">All categories</option>
<?php foreach ($categories as $categoryId => $categoryName): ?>
<?php if ($c == $categoryId): ?>
                            <option value="<?php echo h($categoryId); ?>" selected><?php echo h($categoryName); ?></option>
<?php else: ?>
                            <option value="<?php echo h($categoryId); ?>"><?php echo h($categoryName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                        </select>
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                    </div>
                </div>
            </form>
        </div>

<?php if (!empty($entries)): ?>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

        <div class="row table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-nowrap">ID</th>
                    <th class="text-nowrap">Category</th>
                    <th class="text-nowrap">Photo</th>
                    <th class="text-nowrap">Title</th>
                    <th class="text-nowrap">Member ID</th>
                    <th class="text-nowrap">Member name</th>
                    <th class="text-nowrap">Judge status</th>
                    <th class="text-nowrap">Entried at</th>
                    <th class="text-nowrap"></th>
                </tr>
<?php foreach ($entries as $entry): ?>
<?php
$categoryName = 'Unknown';
foreach ($categories as $key => $value) {
    if ($entry->apply_genre == $key) {
        $categoryName = $value;
        break;
    }
}
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
                <tr>
                    <td class="text-nowrap"><?php echo h($entry->regist_apply_no); ?></td>
                    <td class="text-nowrap"><?php echo h($categoryName); ?></td>
                    <td class="text-nowrap">
<?php if ($entry->apply_genre == 6): ?>
<?php
$embedcode       = $entry->apply_image;
$small_embedcode = preg_replace(
    ['/width="\d+"/i', '/height="\d+"/i', '/<p>.*<\/p>/'],
    [sprintf('width="%d"', 160), sprintf('height="%d"', 90), ''],
    $embedcode
);
echo $small_embedcode;
?>
<?php else: ?>
                        <a class="image-link" href="/manager/entry/image/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>">
                            <img src="/manager/entry/thumbnail/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" width="160">
                        </a>
<?php endif; ?>
                    </td>
                    <td class="text-nowrap"><?php echo h($entry->image_title); ?></td>
                    <td class="text-nowrap"><a href="/manager/member/show/<?php echo h($entry->member_regist_no); ?>"><?php echo h($entry->member_regist_no); ?></a></td>
                    <td class="text-nowrap"><?php echo h($entry->name_m); ?> <?php echo h($entry->name_s); ?></td>
                    <td class="text-nowrap"><?php echo h($judgeStatus); ?></td>
                    <td class="text-nowrap"><?php echo h($entry->entry_date); ?></td>
                    <td class="text-nowrap">
                        <p><a href="/manager/entry/show/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>?c=<?php echo h($c); ?>&amp;q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-primary btn-xs" role="button">Detail</a></p>
                        <p><a href="/manager/entry/download/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">Download</a></p>
                    </td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

<?php endif; ?>

    </div><!-- /container -->

<script>
$(document).ready(function() {
    $('.image-link').magnificPopup({
        type: 'image'
    });
    $('.selectpicker').selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
