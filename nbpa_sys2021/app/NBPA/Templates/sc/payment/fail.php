<?php $locale     = 'sc' ?>
<?php $page_title = 'Payment fail' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <div id="regist_form">
                <p class="confirm_red">支付失败</p>

                <div align="center">
                    <?php if (!empty($errInfo)): ?>
                    <p>Error Info:
                        <?php echo h($errInfo); ?>
                    </p>
                    <?php endif; ?>
                    <a href="/user/member/home"><span class="text14">| 返回 |</span></a>
                </div>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>