<?php $locale     = 'ja' ?>
<?php $page_title = '確認' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
  <div id="container">
    <div id="content">
      <h1 class="mainTi">会員登録確認画面</h1>
      <div id="regist_form">
        <!-- Signup form -->
        <form id="frm_signup" method="post" action="/user/member/signup">
          <input type="hidden" name="_METHOD" value="PUT">

          <table class="input_table">
            <tr>
              <th>メールアドレス</th>
              <td>
                <?php echo h($mail); ?>
              </td>
            </tr>
            <tr>
              <th>名</th>
              <td>
                <?php echo h($name_f); ?>
              </td>
            </tr>
            <tr>
              <th>姓</th>
              <td>
                <?php echo h($name_l); ?>
              </td>
            </tr>
            <tr>
              <th>住所</th>
              <td>
                <?php echo h($addr); ?>
              </td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>
                <?php echo h($zipcode); ?>
              </td>
            </tr>
            <tr>
              <th>国名</th>
              <td>
                <?php foreach ($countries as $key => $val): ?>
                <?php if ($key == $country): ?>
                <?php echo h($val); ?>
                <?php endif; ?>
                <?php endforeach; ?>
              </td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>
                <?php echo h($tel); ?>
              </td>
            </tr>
            <tr>
              <th>携帯電話番号</th>
              <td>
                <?php echo h($mb_tel); ?>
              </td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td>
                <?php echo h($password); ?>
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td>
                <?php if ($gender == 1): ?>
                女性
                <?php elseif ($gender == 2): ?>
                男性
                <?php endif; ?>
              </td>
            </tr>
            <?php if (isset($promo_code)): ?>
            <tr>
              <th>Promotion Code</th>
              <td>
                <?php echo h($promo_code); ?>
              </td>
            </tr>
            <?php endif; ?>
            <tr>
              <th>どのように知りましたか？</th>
              <td>
                <ul>
                  <?php foreach ($enquetes as $key => $val): ?>
                  <?php if (in_array($key, $enquete)): ?>
                  <li>
                    <?php echo h($val); ?>
                  </li>
                  <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
              </td>
            </tr>
          </table>
          <ul class="submitList">
            <li><input type="submit" name="back" value="戻る" class="backBtn"></li>
            <li><input type="submit" name="send" value="送信する" class="submitBtn"></li>
          </ul>

        </form>
        <!-- /Signup form -->
      </div><!-- regist_form END -->
    </div><!-- contant END -->
  </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>