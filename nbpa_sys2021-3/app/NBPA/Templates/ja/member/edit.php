<?php $locale     = 'ja' ?>
<?php $page_title = '編集' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
  <div id="container">
    <div id="content">
      <h1 class="mainTi">編集</h1>
      <div id="regist_form">
        <p class="m20">入力は全て<span class="required">ローマ字入力</span>でお願いします。</p>
        <!-- Edit form -->
        <form id="frm_edit" method="post" action="/user/member/edit">

          <!-- Error Messages -->
          <?php if (isset($flash[ 'error'])): ?>
          <div>
            <ul>
              <?php $errors=$flash['error']; ?>
              <?php foreach ($errors as $error): ?>
              <li>
                <?php echo h($error); ?>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php endif; ?>


          <table class="input_table">
            <tr>
              <th>
                <label>メールアドレス</label>
              </th>
              <td>
                <input type="text" id="mail" name="mail" value="<?php echo h($mail); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>メールアドレス再入力</label>
              </th>
              <td>
                <input type="text" id="mail_chk" name="mail_chk" value="<?php echo h($mail_chk); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>名</label>
              </th>
              <td>
                <input type="text" id="name_f" name="name_f" value="<?php echo h($name_f); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>姓</label>
              </th>
              <td>
                <input type="text" id="name_l" name="name_l" value="<?php echo h($name_l); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>住所</label>
              </th>
              <td>
                <input type="text" id="addr" name="addr" value="<?php echo h($addr); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>郵便番号</label>
              </th>
              <td>
                <input type="text" id="zipcode" name="zipcode" value="<?php echo h($zipcode); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>国名</label>
              </th>
              <td>
                <select name="country">
                  <option value="0">国名を選んでください。</option>
                  <?php foreach ($countries as $key=> $value): ?>
                  <?php if ($key == $country): ?>
                  <option value="<?php echo h($key); ?>" selected>
                    <?php echo h($value); ?>
                  </option>
                  <?php else: ?>
                  <option value="<?php echo h($key); ?>">
                    <?php echo h($value); ?>
                  </option>
                  <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>
                <label>電話番号</label>
              </th>
              <td>
                <input type="text" id="tel" name="tel" value="<?php echo h($tel); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>携帯電話番号</label>
              </th>
              <td>
                <input type="text" id="mb_tel" name="mb_tel" value="<?php echo h($mb_tel); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>パスワード</label>
              </th>
              <td>
                <input type="password" id="password" name="password" value="<?php echo h($password); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>パスワード再入力</label>
              </th>
              <td>
                <input type="password" id="password_chk" name="password_chk" value="<?php echo h($password_chk); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>性別</label>
              </th>
              <td>
                <?php if ($gender == 1): ?>
                <input type="radio" id="gender" name="gender" value="1" checked> 女性
                <input type="radio" id="gender" name="gender" value="2"> 男性
                <?php elseif ($gender == 2): ?>
                <input type="radio" id="gender" name="gender" value="1"> 女性
                <input type="radio" id="gender" name="gender" value="2" checked> 男性
                <?php else: ?>
                <input type="radio" id="gender" name="gender" value="1"> 女性
                <input type="radio" id="gender" name="gender" value="2"> 男性
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <th>
                <label>どのように知りましたか？</label>
              </th>
              <td>
                <?php foreach ($enquetes as $key=> $value): ?>
                <?php if (!empty($enquete)): ?>
                <?php if (in_array($key, $enquete)): ?>
                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>" checked>
                <?php echo h($value); ?>
                <br>
                <?php else: ?>
                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>">
                <?php echo h($value); ?>
                <br>
                <?php endif; ?>
                <?php else: ?>
                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>">
                <?php echo h($value); ?>
                <br>
                <?php endif; ?>
                <?php endforeach; ?>
              </td>
            </tr>
          </table>
          <ul class="submitList">
            <li>
              <input type="submit" name="back" value="戻る" class="backBtn">
            </li>
            <li>
              <input type="submit" name="confirmation" value="確認する" class="submitBtn">
            </li>
          </ul>
        </form>
        <!-- /Edit form -->
      </div>
      <!-- regist_form END -->
    </div>
    <!-- contant END -->
  </div>
  <!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>