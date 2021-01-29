<?php $locale = 'ja' ?>
<?php $title  = 'title' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

  <div id="container">
    <div id="content">
      <h1 class="mainTi">写真をアップロード</h1>
      <div id="regist_form">

        <!-- Entry form -->
        <form id="frm_entry" method="post" action="/user/entry/entry" enctype="multipart/form-data">
          <input type="hidden" name="t" value="<?php echo h($t); ?>">

          <!-- Error Messages -->
          <?php if (isset($flash[ 'error'])): ?>
          <div>
            <ul>
              <?php $errors=$flash[ 'error']; ?>
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
                <label>部門</label>
              </th>
              <td>
                <select name="category">
                  <?php foreach ($categories as $categoryId=> $categoryName): ?>
                  <?php if ($category == $categoryId): ?>
                  <option value="<?php echo h($categoryId); ?>" selected>
                    <?php echo h($categoryName); ?>
                  </option>
                  <?php else: ?>
                  <option value="<?php echo h($categoryId); ?>">
                    <?php echo h($categoryName); ?>
                  </option>
                  <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>
                <label>タイトル</label>
              </th>
              <td>
                <input type="text" id="title" name="title" value="<?php echo h($title); ?>">
              </td>
            </tr>
            <tr>
              <th>
                <label>写真</label>
              </th>
              <td>
                <input type="file" id="filename" name="filename" accept="image/jpeg" value="<?php echo h($filename); ?>">
                <p>72ppiで500kbytes以下のjpegファイルをアップロードしてください。</p>
              </td>
            </tr>
          </table>
          <input type="hidden" id="agreement" name="agreement" value="1">

          <ul class="submitList">
            <li>
              <input type="submit" name="back" value="戻る" class="backBtn">
            </li>
            <li>
              <input type="submit" name="confirmation" value="確認する" class="submitBtn">
            </li>
          </ul>

        </form>
        <!-- /Entry form -->
      </div>
      <!-- regist_form END -->
    </div>
    <!-- contant END -->
  </div>
  <!-- container END -->


</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>