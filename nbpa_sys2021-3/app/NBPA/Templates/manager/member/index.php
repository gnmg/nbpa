<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
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

        <?php if (isset($flash['message'])): ?>
        <div class="row">
            <div class="alert alert-info">
                <?php echo h($flash['message']); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- search -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="get" action="/manager/member/index">
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="q" name="q" value="<?php echo h($q); ?>" placeholder="Search keyword: First name, Last name, Mail address">
                        </div>
                        <select class="selectpicker" name="c">
                            <option value="0">All countries</option>
<?php foreach ($countries as $countryCode => $countryName): ?>
<?php if ($c == $countryCode): ?>
                            <option value="<?php echo h($countryCode); ?>" selected><?php echo h($countryName); ?></option>
<?php else: ?>
                            <option value="<?php echo h($countryCode); ?>"><?php echo h($countryName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-default" name="action" value="show"><span class="glyphicon glyphicon-search"></span> Show</button>
                        <button type="submit" class="btn btn-default" name="action" value="csv"><span class="glyphicon glyphicon-download"></span> CSV Download</button>
                    </form>
                </div>
            </div>
        </div>

<?php if (!empty($members)): ?>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

        <div class="row table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th class="text-nowrap">ID</th>
                    <th class="text-nowrap">Mail address</th>
                    <th class="text-nowrap">First name</th>
                    <th class="text-nowrap">Last name</th>
                    <th class="text-nowrap">Address</th>
                    <th class="text-nowrap">Country</th>
                    <th class="text-nowrap">Postal code</th>
                    <th class="text-nowrap">Telephone</th>
                    <th class="text-nowrap">Mobile</th>
                    <th class="text-nowrap">Gender</th>
                    <th class="text-nowrap">Registered at</th>
                    <th class="text-nowrap"></th>
                </tr>
<?php foreach ($members as $member): ?>
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
                <tr>
                    <td class="text-nowrap"><?php echo h($member->member_regist_no); ?></td>
                    <td class="text-nowrap"><?php echo h($member->mail); ?></td>
                    <td class="text-nowrap"><?php echo h($member->name_m); ?></td>
                    <td class="text-nowrap"><?php echo h($member->name_s); ?></td>
                    <td class="text-nowrap"><?php echo h($member->apname); ?></td>
                    <td class="text-nowrap"><?php echo h($member->pref); ?></td>
                    <td class="text-nowrap"><?php echo h($member->zipcode1); ?></td>
                    <td class="text-nowrap"><?php echo h($member->tel); ?></td>
                    <td class="text-nowrap"><?php echo h($member->mb_tel); ?></td>
                    <td class="text-nowrap"><?php echo h($member->sex); ?></td>
                    <td class="text-nowrap"><?php echo h($member->entry_date); ?></td>
                    <td class="text-nowrap">
<?php if (!empty($member->promotion_code)): ?>
                        <a href="/manager/member/show/<?php echo h($member->member_regist_no); ?>?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-warning btn-xs" role="button">Detail</a>
<?php else: ?>
                        <a href="/manager/member/show/<?php echo h($member->member_regist_no); ?>?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>" class="btn btn-primary btn-xs" role="button">Detail</a>
<?php endif; ?>
                    </td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>

<?php include dirname(__FILE__) . '/../_pager.php'; ?>

<?php endif; ?>

    </div><!-- /container -->

<script type="text/javascript">
$(document).ready(function(){
    $(".selectpicker").selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
