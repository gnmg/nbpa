<?php $locale     = 'en' ?>
<?php $page_title = 'Verified' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">Completion｜Registration</h1>
            <div id="regist_form">
                <p class="confirm_red">
                    <?php if (isset($flash['message'])): ?>
                    <?php echo $flash['message']; ?>
                    <?php endif; ?>
                </p>
                <br />
                <div class="submitBtn2 pb20"><a href="/user/member/logon" class="aligncenter">Login</a></div>

                <ul class="submitList">
                    <li><a href="/user/member/logon">Back</a></li>
                    <li><a href="/">Home</a></li>
                </ul>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>