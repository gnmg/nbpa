<?php include dirname(__FILE__).'/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li>Analytics</li>
                <li>Members</li>
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
                    <form class="form-inline" role="form" method="get" action="/campaign/members/">
                        <div class="form-group">
                            <label class="sr-only" for="code">Promotion Code</label>
                            <input type="text" class="form-control" id="code" name="code" value="<?php echo h($code); ?>" placeholder="Promotion Code">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="start">Start</label>
                            <input type="date" class="form-control" id="start" name="start" value="<?php echo h($start); ?>" placeholder="Start">
                        </div>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <div class="form-group">
                            <label class="sr-only" for="end">End</label>
                            <input type="date" class="form-control" id="end" name="end" value="<?php echo h($end); ?>" placeholder="End">
                        </div>
                        <button type="submit" class="btn btn-default" name="action" value="show"><span class="glyphicon glyphicon-search"></span> Show</button>
                    </form>
                </div>
            </div>
        </div>

<?php if (!empty($members)): ?>

        <div class="row col-md-3">
            <table class="table table-striped table-hover">
                <tr>
                    <th class="text-nowrap">Date</th>
                    <th class="text-nowrap">Total</th>
                </tr>
<?php foreach ($dates as $date): ?>
                <tr>
                    <td class="text-nowrap"><?php echo h($date); ?></td>
                    <td class="text-nowrap text-right"><?php echo h(number_format($members[$date][0])); ?></td>
                </tr>
<?php endforeach; ?>
                <tr>
                    <th class="text-nowrap">Summary</th>
                    <td class="text-nowrap text-right"><?php echo h(number_format($members['summary'][0])); ?></td>
                </tr>
            </table>
        </div>

<?php endif; ?>

    </div><!-- /container -->

<script>
    $(function() {
        $("#start").datepicker({dateFormat: 'yy-mm-dd'});
        $("#end").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>

<?php include dirname(__FILE__).'/../_footer.php'; ?>
