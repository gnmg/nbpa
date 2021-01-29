<?php include dirname(__FILE__) . '/../_header.php'; ?>

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

                <form method="post" action="/manager/payment/saveBank">

                    <!-- command -->
                    <div class="row">
                        <div class="well well-sm">
                            <a href="/manager/payment/addBank?q=<?php echo h($q); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-default"><span class="glyphicon glyphicon-menu-left"></span> Back</a>
                            <button type="submit" class="btn btn-primary" name="action" value="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                        </div>
                    </div>

                    <div class="row">

                        <table class="table table-striped table-hover table-condensed">
                            <tr>
                                <th>Member ID</th>
                                <td><?php echo h($memberId); ?></td>
                                <input type="hidden" name="uid" value="<?php echo h($memberId); ?>">
                            </tr>
                            <tr>
                                <th>Member Name</th>
                                <td><?php echo h($member->name_m) . ' ' . h($member->name_s); ?></td>
                            </tr>
                            <tr>
                                <th>Transaction Number</th>
                                <td><?php echo h($txNo); ?></td>
                                <input type="hidden" name="tx_no" value="<?php echo h($txNo); ?>">
                            </tr>
                            <tr>
                                <th>Transaction Date</th>
                                <td><?php echo h($createdAt); ?></td>
                                <input type="hidden" name="created_at" value="<?php echo h($createdAt); ?>">
                            </tr>
                        </table>

                    </div>

                </form>

            </div>
        </div>

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
