<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Contest</li>
                <li>Judges</li>
            </ol>
        </div><!-- /row -->

<?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
<?php endif; ?>
<?php if (isset($flash['message'])): ?>
        <div class="row">
            <div class="alert alert-success">
                <?php echo h($flash['message']); ?>
            </div>
        </div>
<?php endif; ?>

<?php if (!empty($judges)): ?>

        <div class="row table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-nowrap">Judge name</th>
                    <th class="text-nowrap">Quota of point</th>
                    <th class="text-nowrap"></th>
                </tr>
<?php foreach ($judges as $judge): ?>
                <tr>
                    <td class="text-nowrap"><?php echo h($judge->name); ?></td>
                    <td class="text-nowrap"><?php echo h($judge->quota); ?></td>
                    <td class="text-nowrap"><a href="/manager/judge/edit/<?php echo h($judge->id); ?>" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a></td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>

<?php endif; ?>

    </div><!-- /container -->

<script type="text/javascript">
$(document).ready(function(){
    $(".selectpicker").selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
