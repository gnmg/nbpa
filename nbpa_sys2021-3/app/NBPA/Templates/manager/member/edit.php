<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Data</li>
                <li><a href="/manager/member/index?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>">Members</a></li>
                <li>ID: <a href="/manager/member/show/<?php echo h($member->member_regist_no); ?>?q=<?php echo h($q); ?>&amp;c=<?php echo h($c); ?>&amp;page=<?php echo h($page); ?>"><?php echo h($member->member_regist_no); ?></a></li>
            </ol>
        </div><!-- /row -->

        <div class="row">
            <?php include dirname(__FILE__) . '/_sidebar.php'; ?>

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

<?php if (!empty($member)): ?>

                <form method="post" action="/manager/member/edit" id="form1">
                    <input type="hidden" name="id" value="<?php echo h($member->member_regist_no); ?>">
                    <input type="hidden" name="q" value="<?php echo h($q); ?>">
                    <input type="hidden" name="c" value="<?php echo h($c); ?>">
                    <input type="hidden" name="page" value="<?php echo h($page); ?>">

                    <!-- command -->
                    <div class="row">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" name="action" value="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                        </div>
                    </div>

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
                                <td>
                                    <input type="mail" class="form-control" name="mail" value="<?php echo h($member->mail); ?>" placeholder="Mail address">
                                </td>
                            </tr>
                            <tr>
                                <th>Mail verified</th>
                                <td>
<?php if ($member->complete_flag): ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="complete_flag" value="0"> No
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="complete_flag" value="1" checked> Yes
                                    </label>
<?php else: ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="complete_flag" value="0" checked> No
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="complete_flag" value="1"> Yes
                                    </label>
<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>First name</th>
                                <td>
                                    <input type="text" class="form-control" name="name_m" value="<?php echo h($member->name_m); ?>" placeholder="First name">
                                </td>
                            </tr>
                            <tr>
                                <th>Last name</th>
                                <td>
                                    <input type="text" class="form-control" name="name_s" value="<?php echo h($member->name_s); ?>" placeholder="Last name">
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>
                                    <input type="text" class="form-control" name="apname" value="<?php echo h($member->apname); ?>" placeholder="Address">
                                </td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>
                                    <select class="selectpicker" name="pref">
<?php foreach ($countries as $countryCode => $countryName): ?>
<?php if ($member->pref == $countryCode): ?>
                                        <option value="<?php echo h($countryCode); ?>" selected><?php echo h($countryName); ?></option>
<?php else: ?>
                                        <option value="<?php echo h($countryCode); ?>"><?php echo h($countryName); ?></option>
<?php endif; ?>
<?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Postal code</th>
                                <td>
                                    <input type="text" class="form-control" name="zipcode1" value="<?php echo h($member->zipcode1); ?>" placeholder="Postal code">
                                </td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td>
                                    <input type="text" class="form-control" name="tel" value="<?php echo h($member->tel); ?>" placeholder="Telephone">
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>
                                    <input type="text" class="form-control" name="mb_tel" value="<?php echo h($member->mb_tel); ?>" placeholder="Mobile">
                                </td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>
<?php if ($member->sex == 1): ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" value="1" checked> Female
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" value="2"> Male
                                    </label>
<?php else: ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" value="1"> Female
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="sex" value="2" checked> Male
                                    </label>
<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Registered at</th>
                                <td><?php echo h($member->entry_date); ?></td>
                            </tr>
                        </table>
                    </div>

<div class="modal" id="modal-delete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal-label">Warning</h4>
            </div>
            <div class="modal-body">
                Delete this member?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="action" value="delete">Delete</button>
            </div>
        </div>
    </div>
</div>

                </form>

<?php endif; ?>

            </div>
        </div>
    </div><!-- /container -->

<script type="text/javascript">
$(document).ready(function(){
    $(".selectpicker").selectpicker();
});
</script>

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
