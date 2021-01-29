<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <!-- datetime -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/payment/index?q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>">Payments</a></li>
                <li>Add Bank Transfer</li>
            </ol>
        </div><!-- /row -->

        <div class="row">
            <div class="col-sm-8 col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body alert-warning">
                        Add one unit transaction ($25.00 USD).
                    </div>
                </div>

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

                <form method="post" action="/manager/payment/confirmBank">

                    <!-- command -->
                    <div class="row">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" name="action" value="save"><span class="glyphicon glyphicon-save"></span> Confirm</button>
                        </div>
                    </div>

                    <div class="row">

                        <label for="uid">Member ID</label>
                        <input type="text" class="form-control" name="uid" id="uid" value="<?php echo h($memberId); ?>">

                        <label for="tx_no">Transaction Number</label>
                        <input type="text" class="form-control" name="tx_no" id="tx_no" value="<?php echo h($txNo); ?>">

                        <div class="form-group">
                            <label for="created_at">Transaction Date</label>
                            <div class="input-group date" id="dtp">
                                <input type="text" class="form-control" name="created_at" id="created_at" value="<?php echo h($createdAt); ?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div><!-- /container -->

<script>
$(function() {
    $('#dtp').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
