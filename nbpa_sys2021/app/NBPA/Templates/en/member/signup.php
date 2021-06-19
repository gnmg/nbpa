<?php $locale     = 'en' ?>
<?php $page_title = 'Sign up' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Registration</h1>
            <div id="regist_form">
                <p class="m20">Please fill out the following form to enter pictures.</p>
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
                    <p class="confirm_red">We are doing some maintenance work on the server right now. Please check back in a couple of hours.</p>
                    <!-- <table class="input_table">
                        <tr>
                            <th><label>E-mail</label> <span class="required">*</span></th>
                            <td><input type="text" id="mail" name="mail" value="<?php echo h($mail); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Re-enter e-mail</label> <span class="required">*</span></th>
                            <td><input type="text" id="mail_chk" name="mail_chk" value="<?php echo h($mail_chk); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>First Name</label> <span class="required">*</span></th>
                            <td><input type="text" id="name_f" name="name_f" value="<?php echo h($name_f); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Last Name</label> <span class="required">*</span></th>
                            <td><input type="text" id="name_l" name="name_l" value="<?php echo h($name_l); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Address</label> <span class="required">*</span></th>
                            <td><input type="text" id="addr" name="addr" value="<?php echo h($addr); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Postal Code</label> <span class="required">*</span></th>
                            <td><input type="text" id="zipcode" name="zipcode" value="<?php echo h($zipcode); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Country</label> <span class="required">*</span></th>
                            <td><select name="country">
                                    <option value="0">Please choose your country</option>
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
                            <th><label>Telephone Number</label> <span class="required">*</span></th>
                            <td><input type="text" id="tel" name="tel" value="<?php echo h($tel); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Mobile Number</label></th>
                            <td><input type="text" id="mb_tel" name="mb_tel" value="<?php echo h($mb_tel); ?>" class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Password</label> <span class="required">*</span></th>
                            <td><input type="password" id="password" name="password" value="<?php echo h($password); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Re-enter password</label> <span class="required">*</span></th>
                            <td><input type="password" id="password_chk" name="password_chk" value="<?php echo h($password_chk); ?>"
                                    class="formText"></td>
                        </tr>
                        <tr>
                            <th><label>Gender</label> <span class="required">*</span></th>
                            <td>
                                <?php if ($gender == 1): ?>
                                <input type="radio" id="gender" name="gender" value="1" checked> Female
                                <input type="radio" id="gender" name="gender" value="2"> Male
                                <?php elseif ($gender == 2): ?>
                                <input type="radio" id="gender" name="gender" value="1"> Female
                                <input type="radio" id="gender" name="gender" value="2" checked> Male
                                <?php else: ?>
                                <input type="radio" id="gender" name="gender" value="1"> Female
                                <input type="radio" id="gender" name="gender" value="2"> Male
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><label>How did you find us?</label></th>
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
                        <?php if (isset($promo_code)): ?>
                        <tr>
                            <th><label>Promotion Code</label></th>
                            <td>
                                <?php echo h($promo_code); ?><input type="hidden" id="promo_code" name="promo_code"
                                    value="<?php echo h($promo_code); ?>" class="formText"></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th colspan="2">
                                <input type="checkbox" name="agreement" value="1"> I agree to the conditions of the
                                <?php echo date("Y"); ?> Nature's Best Photography Asia photography contest, set forth in the competition
                                guidelines.
                            </th>
                        </tr>
                    </table>
                    <ul class="submitList">
                        <li><input type="submit" name="back" value="Back" class="backBtn"></li>
                        <li><input type="submit" name="confirmation" value="Confirmation" class="submitBtn"></li>
                    </ul>

                </form> -->
                <!-- /Signup form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>