<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Communication</li>
                <li>Mail</li>
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
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="/manager/communication/index">
                        <select class="selectpicker" name="kind">
                            <option value="1">Registered</option>
                            <option value="2">Entried</option>
                            <option value="3">Not entried</option>
                            <option value="4">1st approved</option>
                            <option value="5">2nd approved</option>
                            <option value="6">Semi final approved</option>
                            <option value="7">Winner</option>
                        </select>
                        <select class="selectpicker" name="year">
                            <option value="0">All year</option>
<?php for ($y = 2015; $y <= date('Y'); $y++): ?>
                            <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
<?php endfor; ?>
                        </select>
                        <button type="submit" class="btn btn-default" name="action" value="csv"><span class="glyphicon glyphicon-download"></span> CSV Download</button>
                    </form>
                </div>
            </div>
        </div>

    </div><!-- /container -->

<script type="text/javascript">
$(document).ready(function(){
    $(".selectpicker").selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
