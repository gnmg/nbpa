<?php $locale     = 'sc' ?>
<?php $page_title = 'Sign Up' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">会员注册</h1>
            <div id="regist_form">
                <p class="m10">提交您的照片作品前，请填写以下表格。</p>
                <p class="m20"><span class="required">请用罗马字输入。</span></p>
                <!-- Signup form -->
                <form id="frm_signup" method="post" action="/user/member/signup">

                    <!-- Error Messages -->
                    <?php if (isset($flash['error'])): ?>
                    <div>
                        <ul>
                            <?php $errors = $flash['error']; ?>
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
                            <th><label>电子邮件地址</label> <span class="required">*</span></th>
                            <td><input type="text" id="mail" name="mail" value="<?php echo h($mail); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>输入电子邮件地址（再次输入）</label> <span class="required">*</span></th>
                            <td><input type="text" id="mail_chk" name="mail_chk" value="<?php echo h($mail_chk); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>名</label> <span class="required">*</span></th>
                            <td><input type="text" id="name_f" name="name_f" value="<?php echo h($name_f); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>姓</label> <span class="required">*</span></th>
                            <td><input type="text" id="name_l" name="name_l" value="<?php echo h($name_l); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>地址</label> <span class="required">*</span></th>
                            <td><input type="text" id="addr" name="addr" value="<?php echo h($addr); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>邮编号码</label> <span class="required">*</span></th>
                            <td><input type="text" id="zipcode" name="zipcode" value="<?php echo h($zipcode); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>国名</label> <span class="required">*</span></th>
                            <td><select name="country">
                                    <option value="0">没输入国名</option>
                                    <?php foreach ($countries as $key => $value): ?>
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
                                </select></td>
                        </tr>
                        <tr>
                            <th><label>电话号码</label> <span class="required">*</span></th>
                            <td><input type="text" id="tel" name="tel" value="<?php echo h($tel); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>手机号码</label></th>
                            <td><input type="text" id="mb_tel" name="mb_tel" value="<?php echo h($mb_tel); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>密码</label> <span class="required">*</span></th>
                            <td><input type="password" id="password" name="password" value="<?php echo h($password); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>输入密码（再次输入）</label> <span class="required">*</span></th>
                            <td><input type="password" id="password_chk" name="password_chk" value="<?php echo h($password_chk); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>性别</label> <span class="required">*</span></th>
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
                            <th><label>怎么知道我们的活动</label></th>
                            <td>
                                <?php foreach ($enquetes as $key => $value): ?>
                                <?php if (!empty($enquete)): ?>
                                <?php if (in_array($key, $enquete)): ?>
                                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>"
                                    checked>
                                <?php echo h($value); ?><br>
                                <?php else: ?>
                                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>">
                                <?php echo h($value); ?><br>
                                <?php endif; ?>
                                <?php else: ?>
                                <input type="checkbox" id="enquete[]" name="enquete[]" value="<?php echo h($key); ?>">
                                <?php echo h($value); ?><br>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <?php if (isset($promo_code)): ?>
                        <tr>
                            <th><label>Promotion Code</label></th>
                            <td>
                                <?php echo h($promo_code); ?><input type="hidden" id="promo_code" name="promo_code"
                                    value="<?php echo h($promo_code); ?>" class="formText"></td>
                        </tr>
                        <?php endif; ?>
                        <th colspan="2">
                            <input type="checkbox" name="agreement" value="1"> 我同意2019年度Nature's Best Photography
                            Asia大赛参赛规定及条件。
                        </th>
                        </tr>
                    </table>
                    <ul class="submitList">
                        <li><input type="submit" name="back" value="返回" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="确认" class="submitBtn"></li>
                    </ul>

                </form>
                <!-- /Signup form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>