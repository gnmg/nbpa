<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li>Sign in</li>
            </ol>
        </div><!-- /row -->

        <?php if (isset($flash['errors'])): ?>
        <div class="row">
            <div class="alert alert-danger">
                <?php echo h($flash['errors']); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <form action="/manager/manager/logon" method="post" class="form-horizontal" role="form">
                <div class="panel panel-default col-lg-4 col-lg-offset-4">
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="user_name" class="sr-only">User Name</label>
                            <input type="text" id="user_name" name="user_name" class="form-control" placeholder="User Name" required autofocus>
                            <label for="user_pass" class="sr-only">User Password</label>
                            <input type="password" id="user_pass" name="user_pass" class="form-control" placeholder="User Password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="sign_in" name="sign_in" class="btn btn-lg btn-primary btn-block">
                                Sign in <span class="glyphicon glyphicon-log-in"></span>
                            </button>
                        </div>

                    </div><!-- /panel-body -->
                </div><!-- /panel -->
            </form>
        </div><!-- /row -->

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
