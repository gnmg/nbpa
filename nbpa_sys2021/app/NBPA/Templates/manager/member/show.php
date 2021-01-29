<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/member/index?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>">Members</a></li>
                <li>ID: <?php echo h($member->member_regist_no); ?></li>
            </ol>
        </div><!-- /row -->

        <div class="row">
            <?php include dirname(__FILE__) . '/_sidebar.php'; ?>

            <div class="col-sm-8 col-md-9">
                <!-- command -->
                <div class="row">
                    <div class="well well-sm">
                        <a href="/manager/member/edit/<?php echo h($member->member_regist_no); ?>?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    </div>
                </div>

<?php if (isset($flash['errors'])): ?>
                <div class="row">
                    <div class="alert alert-danger">
                        <?php echo h($flash['errors']); ?>
                    </div>
                </div>
<?php endif; ?>
<?php if (isset($flash['message'])): ?>
                <div class="row">
                    <div class="alert alert-info">
                        <?php echo h($flash['message']); ?>
                    </div>
                </div>
<?php endif; ?>

<?php if (!empty($member)): ?>
<?php
    // country
    foreach ($countries as $key => $value) {
        if ($key == $member->pref) {
            $member->pref = $value;
            break;
        }
    }
    // gender
    if ($member->sex == 1) {
        $member->sex = 'Female';
    } elseif ($member->sex == 2) {
        $member->sex = 'Male';
    } else {
        $member->sex = 'Unknown';
    }
?>

                <div class="row">
                    <table class="table table-striped table-hover -table-condensed">
                        <colgroup>
                            <col class="col-xs-3">
                            <col class="col-xs-9">
                        </colgroup>
                        <tr>
                            <th>ID</th>
                            <td><?php echo h($member->member_regist_no); ?></td>
                        </tr>
                        <tr>
                            <th>Mail address</th>
                            <td><?php echo h($member->mail); ?></td>
                        </tr>
                        <tr>
                            <th>Mail verified</th>
                            <td><?php echo $member->complete_flag ? 'Yes' : 'No'; ?></td>
                        </tr>
                        <tr>
                            <th>First name</th>
                            <td><?php echo h($member->name_m); ?></td>
                        </tr>
                        <tr>
                            <th>Last name</th>
                            <td><?php echo h($member->name_s); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo h($member->apname); ?></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td><?php echo h($member->pref); ?></td>
                        </tr>
                        <tr>
                            <th>Postal code</th>
                            <td><?php echo h($member->zipcode1); ?></td>
                        </tr>
                        <tr>
                            <th>Telephone</th>
                            <td><?php echo h($member->tel); ?></td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td><?php echo h($member->mb_tel); ?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?php echo h($member->sex); ?></td>
                        </tr>
                        <tr>
                            <th>Promotion Code</th>
                            <td><?php echo h($member->promotion_code); ?></td>
                        </tr>
                        <tr>
                            <th>Registered at</th>
                            <td><?php echo h($member->entry_date); ?></td>
                        </tr>
                    </table>
                </div>

<?php endif; ?>

            </div>
        </div>
    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
