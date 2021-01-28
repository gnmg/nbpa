<?php $locale     = 'ko' ?>
<?php $page_title = 'Complete' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">비밀번호를 변경해 주세요.</h1>
            <div id="regist_form">
                <p class="confirm_red">새로운 비밀번호가 등록되었습니다.</p>

                <br />
                <ul class="submitList">
                    <li><a href="/user/member/logon">돌아가기</a></li>
                </ul>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>