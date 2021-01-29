<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li>Payments</li>
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
            <form method="get" action="/manager/payment/index">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="search" class="form-control" id="q" name="q" value="<?php echo h($q); ?>" placeholder="Search keyword: Reference Number, Transaction Number, Member ID">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-10">
                <a href="/manager/payment/addBank?q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus"></span> Add Bank Transfer</a>
            </div>
        </div>

<?php if (!empty($payments)): ?>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

        <form method="post" action="/manager/payment/chgStatus">
        <input type="hidden" name="page" value="<?php echo h($page); ?>">
        <input type="hidden" name="q" value="<?php echo h($q); ?>">
        <div class="row">
            <div class="col-md-2 col-md-offset-10">
                <input class="btn btn-default" type="submit" name="toInvalid" value="To Invalid"></button>
                <input class="btn btn-default" type="submit" name="toValid" value="To Valid"></input>
            </div>
        </div>
        <br>
        <div class="row table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-nowrap"></th>
                    <th class="text-nowrap">ID</th>
                    <th class="text-nowrap">Member ID</th>
                    <th class="text-nowrap">Member name</th>
                    <th class="text-nowrap">Service</th>
                    <th class="text-nowrap">Reference number</th>
                    <th class="text-nowrap">Transaction number</th>
                    <th class="text-nowrap">Amount</th>
                    <th class="text-nowrap">Paid at</th>
                    <th class="text-nowrap">Status</th>
                    <th class="text-nowrap"></th>
                </tr>
<?php foreach ($payments as $payment): ?>
                <tr>
                    <td class="text-nowrap"><input type="checkbox" name="payid[]" value="<?php echo h($payment->id); ?>"></td>
                    <td class="text-nowrap"><?php echo h($payment->id); ?></td>
                    <td class="text-nowrap"><a href="/manager/member/show/<?php echo h($payment->member_regist_no); ?>"><?php echo h($payment->member_regist_no); ?></a></td>
                    <td class="text-nowrap"><?php echo h($payment->name_m); ?> <?php echo h($payment->name_s); ?></td>
                    <td class="text-nowrap">
<?php
if ($payment->kind == 1) {
    echo 'PayDollar';
} elseif ($payment->kind == 2) {
    echo 'PayPal';
} elseif ($payment->kind == 3) {
    echo 'Bank Transfer';
} elseif ($payment->kind == 4) {
    echo 'GMO PG MCP';
} else {
    echo 'Unknown';
}
?>
                    </td>
<?php if ($payment->kind == 4): ?>
                    <td class="text-nowrap"><?php echo h(str_replace('.', '-', $payment->ref_no)); ?></td>
<?php else: ?>
                    <td class="text-nowrap"><?php echo h($payment->ref_no); ?></td>
<?php endif; ?>
                    <td class="text-nowrap"><?php echo h($payment->tx_no); ?></td>
                    <td class="text-nowrap"><?php echo h($payment->amount); ?></td>
                    <td class="text-nowrap"><?php echo h($payment->created_at); ?></td>
                    <td class="text-nowrap"><?php if ($payment->result_code == 0) {
    echo '<span>Valid</span>';
} else {
    echo '<span class="text-danger">Invalid</span>';
} ?></td>
<?php if ($payment->kind == 1 || $payment->kind == 2 || $payment->kind == 4): ?>
                    <td class="text-nowrap"><a href="/manager/payment/show/<?php echo h($payment->id); ?>?q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-primary btn-xs" role="button">Detail</a></td>
<?php else: ?>
                    <td></td>
<?php endif; ?>
                </tr>
<?php endforeach; ?>
            </table>
        </div>
        </form>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

<?php endif; ?>

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
