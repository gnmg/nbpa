<?php $locale     = 'ja' ?>
<?php $page_title = '完了' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
  <div id="container">
    <div id="content">
      <h1 class="mainTi">パスワードを変更して下さい。</h1>
      <div id="regist_form">
        <p class="confirm_red">新しいパスワードが登録されました。</p>

        <br />
        <ul class="submitList">
          <li><a href="/user/member/logon">戻る</a></li>
        </ul>
      </div><!-- regist_form END -->
    </div><!-- contant END -->
  </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>