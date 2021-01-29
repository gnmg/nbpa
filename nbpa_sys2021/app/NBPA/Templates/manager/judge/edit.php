<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/js/bootstrap-select.min.js"></script>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Contest</li>
                <li><a href="/manager/judge/index">Judge</a></li>
                <li>ID: <?php echo h($judge->id); ?></li>
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

<?php if (!empty($judge)): ?>

                <form method="post" action="/manager/judge/edit">
                    <input type="hidden" name="id" value="<?php echo h($judge->id); ?>">

                    <!-- command -->
                    <div class="row">
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" name="action" value="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-striped table-hover -table-condensed">
                            <colgroup>
                                <col class="col-xs-3">
                                <col class="col-xs-9">
                            </colgroup>
                            <tr>
                                <th>Judge name</th>
                                <td><input type="text" class="form-control" name="name" value="<?php echo h($judge->name); ?>"></td>
                            </tr>
                            <tr>
                                <th>Quota of point</th>
                                <td><input type="text" class="form-control" name="quota" value="<?php echo h($judge->quota); ?>"></td>
                            </tr>
                        </table>
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
