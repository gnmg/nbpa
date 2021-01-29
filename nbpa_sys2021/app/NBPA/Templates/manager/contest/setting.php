<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <!-- picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <!-- datetime -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Contest</li>
                <li>Settings</li>
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

        <form method="post" action="/manager/contest/setting" role="form" class="form-inline">

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-inline">
                        <div class="col-md-2 control-label">Duration for submit</div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="sr-only" for="start1">Start</label>
                                <div class="input-group date" id="dtp1">
                                    <input type="text" class="form-control" id="start1" name="start1" value="<?php echo h($start1); ?>" placeholder="Start">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <div class="form-group">
                                <label class="sr-only" for="end1">End</label>
                                <div class="input-group date" id="dtp2">
                                    <input type="text" class="form-control" id="end1" name="end1" value="<?php echo h($end1); ?>" placeholder="End">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker" name="timezone1">
<?php
$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
foreach ($tzlist as $tzname) {
    if ($tzname == $timezone1) {
        echo '<option value="' . $tzname . '" selected>' . $tzname . '</option>';
    } else {
        echo '<option value="' . $tzname . '">' . $tzname . '</option>';
    }
}
?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-inline">
                        <div class="col-md-2 control-label">Duration for pay</div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="sr-only" for="start2">Start</label>
                                <div class="input-group date" id="dtp3">
                                    <input type="text" class="form-control" id="start2" name="start2" value="<?php echo h($start2); ?>" placeholder="Start">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <div class="form-group">
                                <label class="sr-only" for="end2">End</label>
                                <div class="input-group date" id="dtp4">
                                    <input type="text" class="form-control" id="end2" name="end2" value="<?php echo h($end2); ?>" placeholder="End">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker" name="timezone2">
<?php
$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
foreach ($tzlist as $tzname) {
    if ($tzname == $timezone2) {
        echo '<option value="' . $tzname . '" selected>' . $tzname . '</option>';
    } else {
        echo '<option value="' . $tzname . '">' . $tzname . '</option>';
    }
}
?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-save"></span> Save</button>
                </div>
            </div>
        </div>

        </form>

    </div><!-- /container -->

<script>
$(function() {
    $('.selectpicker').selectpicker();
    $('#dtp1').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('#dtp2').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('#dtp3').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('#dtp4').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
