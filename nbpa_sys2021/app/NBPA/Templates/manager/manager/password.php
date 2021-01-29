<?php include dirname(__FILE__) . '/../_header.php'; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="/manager/manager/dashboard">Dashboard</a></li>
                <li>Change password</li>
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

        <div class="row">
            <form method="post" action="/manager/manager/password">
                <div class="form-group">
                    <label for="currentPassword">Current password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="current password">
                </div>
                <div class="form-group">
                    <label for="newPassword">New password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="new password">
                </div>
                <div class="form-group">
                    <label for="verifyPassword">Verify password</label>
                    <input type="password" class="form-control" id="verifyPassword" name="verifyPassword" placeholder="verify password">
                </div>
                <button type="submit" class="btn btn-default">Change password</button>
            </form>
        </div>

    </div><!-- /container -->

<?php include dirname(__FILE__) . '/../_footer.php'; ?>
