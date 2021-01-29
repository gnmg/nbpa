<?php include dirname(__FILE__) . '/../_header.php'; ?>

<style type="text/css">
.pict-thumbnail {
    height: 260px;
}
.pict-thumbnail a {
    line-height: 240px;
}
.borderless td, .borderless th {
    border: none !important;
}
</style>

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
                <li>Contest</li>
                <li>Judging</li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if (isset($flash['messages'])): ?>
        <div class="row">
            <div class="alert alert-info">
                <?php echo h($flash['messages']); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- search -->
        <div class="row">
            <form method="get" action="/manager/contest/index">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <!-- category -->
                            <select class="selectpicker" name="c" id="c">
<?php foreach ($categories as $categoryCode => $categoryName): ?>
<?php if ($categoryCode == $category): ?>
                                <option value="<?php echo h($categoryCode); ?>" selected><?php echo h($categoryName); ?></option>
<?php else: ?>
                                <option value="<?php echo h($categoryCode); ?>"><?php echo h($categoryName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                            </select>
                            <!-- stage -->
                            <select class="selectpicker" name="s" id="s">
<?php foreach ($stages as $stageCode => $stageName): ?>
<?php if ($stage == $stageCode): ?>
                                <option value="<?php echo h($stageCode); ?>" selected><?php echo h($stageName); ?></option>
<?php else: ?>
                                <option value="<?php echo h($stageCode); ?>"><?php echo h($stageName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                            </select>
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

<?php if (!empty($entries)): ?>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

        <form method="post" action="/manager/contest/save">
        <div class="row">
<?php foreach ($entries as $entry): ?>
            <div class="col-xs-6 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center pict-thumbnail">
<?php if ($entry->apply_genre == 6): ?>
<?php
$embedcode       = $entry->apply_image;
$small_embedcode = preg_replace(
    ['/width="\d+"/i', '/height="\d+"/i', '/<p>.*<\/p>/'],
    [sprintf('width="%d"', 320), sprintf('height="%d"', 180), ''],
    $embedcode
);
echo $small_embedcode;
?>
<?php else: ?>
                        <a class="image-link" href="/manager/contest/image/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>">
                            <img src="/manager/contest/thumbnail/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>">
                        </a>
<?php endif; ?>
                    </div>
                    <div class="panel-body">
                        <p><a href="/manager/entry/show/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" target="_blank"><?php echo h($entry->image_title); ?></a></p>
                        <!-- <p><a href="/manager/member/show/<?php echo h($entry->member_regist_no); ?>" target="_blank"><?php echo h($entry->name_m); ?> <?php echo h($entry->name_s); ?></a></p> -->
                        <p><?php echo h($entry->entry_date); ?></p>
<?php if (!empty($entry->staff_comment)): ?>
                        <p class="bg-info"><?php echo nl2br(h($entry->staff_comment)); ?></p>
<?php endif; ?>
<?php if (!empty($entry->highres_photo_name)): ?>
<?php if ($entry->apply_genre != 6): ?>
                        <p><a href="/manager/entry/hiresdownload/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">High resolution file Download</a></p>
<?php endif; ?>
<?php endif; ?>
<?php if (!empty($entry->raw_file)): ?>
                        <p><a href="/manager/entry/rawdownload/<?php echo h($entry->member_regist_no); ?>/<?php echo h($entry->regist_apply_no); ?>" class="btn btn-info btn-xs">RAW file Download</a></p>
<?php endif; ?>
                    </div>
                    <div class="panel-footer">
<?php if ($stage === \NBPA\Models\Contest::STAGE_1ST_POINT ||
          $stage === \NBPA\Models\Contest::STAGE_2ND_POINT ||
          $stage === \NBPA\Models\Contest::STAGE_SEMI_FINAL_POINT): ?>
                        <table class="table borderless">
<?php foreach ($judges as $judge): ?>
                            <tr>
                                <th><?php echo h($judge->name); ?></th>
                                <td>
<div class="btn-group" data-toggle="buttons">
<?php for ($i = 0; $i <= $judge->quota; $i++): ?>
<?php if ($i == 0): ?>
                                    <label class="btn btn-default btn-xs"><input type="radio" autocomplete="off" value="<?php echo h($i); ?>" name="point[<?php echo h($entry->regist_apply_no); ?>][<?php echo h($judge->id); ?>]" checked> <?php echo h($i); ?></label>
<?php else: ?>
<?php if ($points[$entry->regist_apply_no][$judge->id] == $i): ?>
                                    <label class="btn btn-default btn-xs active"><input type="radio" autocomplete="off" value="<?php echo h($i); ?>" name="point[<?php echo h($entry->regist_apply_no); ?>][<?php echo h($judge->id); ?>]" checked> <?php echo h($i); ?></label>
<?php else: ?>
                                    <label class="btn btn-default btn-xs"><input type="radio" autocomplete="off" value="<?php echo h($i); ?>" name="point[<?php echo h($entry->regist_apply_no); ?>][<?php echo h($judge->id); ?>]"> <?php echo h($i); ?></label>
<?php endif; ?>
<?php endif; ?>
<?php endfor; ?>
</div>
                                </td>
                            </tr>
<?php endforeach; ?>
                        </table>
<?php elseif ($stage === \NBPA\Models\Contest::STAGE_1ST_APPROVE ||
              $stage === \NBPA\Models\Contest::STAGE_2ND_APPROVE ||
              $stage === \NBPA\Models\Contest::STAGE_SEMI_FINAL_APPROVE): ?>
                        <table class="table borderless">
                            <tr>
                                <th>Point(Avg):</th>
                                <td>
<?php
$sum = 0.0; $avg = 0.0; $n = 0;
foreach ($points[$entry->regist_apply_no] as $judgeId => $point) {
    $n++;
    $sum += $point;
    $avg = $sum / $n;
}
echo h(number_format($sum, 1));
echo '(' . h(number_format($avg, 2)) . ')';
?>
                                </td>
                                <th>Status:</th>
                                <td>
<?php
if ($entry->judge_status > $stage) {
    echo 'Passed';
} else {
    echo 'Not passed';
}
?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
<?php if ($entry->judge_status > $stage): ?>
                                    <input type="radio" name="pass[<?php echo h($entry->regist_apply_no); ?>]" value="0"> Not passed<br>
                                    <input type="radio" name="pass[<?php echo h($entry->regist_apply_no); ?>]" value="1" checked> Passed
<?php else: ?>
                                    <input type="radio" name="pass[<?php echo h($entry->regist_apply_no); ?>]" value="0" checked> Not passed<br>
                                    <input type="radio" name="pass[<?php echo h($entry->regist_apply_no); ?>]" value="1"> Passed
<?php endif; ?>
                                </td>
                            </tr>
                        </table>
<?php elseif ($stage === \NBPA\Models\Contest::STAGE_FINAL): ?>
                        <table class="table borderless">
                            <tr>
                                <th>Category:</th>
                                <td>
<?php
$categoryName = '';
foreach ($categories as $code => $name) {
    if ($entry->apply_genre == $code) {
        $categoryName = $name;
    }
}
echo h($categoryName);
?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="0" checked style="display:none;">
<?php if ($entry->judge_status & 0x10): ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="16" checked> Runner Ups<br>
<?php else: ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="16"> Runner Ups<br>
<?php endif; ?>
<?php if ($entry->judge_status & 0x20): ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="32" checked> Category<br>
<?php else: ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="32"> Category<br>
<?php endif; ?>
<?php if ($entry->judge_status & 0x40): ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="64" checked> Smithonian
<?php else: ?>
                                    <input type="checkbox" name="award[<?php echo h($entry->regist_apply_no); ?>][]" value="64"> Smithonian
<?php endif; ?>
                                </td>
                            </tr>
                        </table>
<?php endif; ?>
                    </div>
                </div>
            </div>
<?php endforeach; ?>
        </div>

        <div class="row">
            <input type="hidden" name="c" value="<?php echo h($category); ?>">
            <input type="hidden" name="s" value="<?php echo h($stage); ?>">
            <input type="hidden" name="page" value="<?php echo h($page); ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-save"></span> Save</button>
                </div>
            </div>
        </div>
        </form>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

<?php endif; ?>


    </div><!-- /container -->

<script>
$(document).ready(function() {
    $('.image-link').magnificPopup({
        type: 'image'
    });
    $('.selectpicker').selectpicker();
    var val = $('#s').val();
    updateStage(val);
});
$('#s').change(function() {
    var val = $(this).val();
    updateStage(val);
});
function updateStage(s) {
    if (s == '6') {
        $('#c').selectpicker('hide');
    } else {
        $('#c').selectpicker('show');
    }
}
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
