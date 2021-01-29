<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/payment/index?q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>">Payments</a></li>
                <li>ID: <?php echo h($payment->id); ?></li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>

<?php if (!empty($payment)): ?>

        <div class="row">
            <table class="table table-striped table-hover table-condensed">
                <colgroup>
                    <col class="col-xs-3">
                    <col class="col-xs-9">
                </colgroup>
<?php foreach ($payment->detail as $key => $val): ?>
                <tr>
                    <th><?php echo h($key); ?></th>
                    <td><?php echo h($val); ?></td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>

<?php endif; ?>

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
