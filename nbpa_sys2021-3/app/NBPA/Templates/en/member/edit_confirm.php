<?php $locale     = 'en' ?>
<?php $page_title = 'Edit Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">Edit</h1>
            <div id="regist_form">



                <!-- Edit form -->
                <form id="frm_edit" method="post" action="/user/member/edit">
                    <input type="hidden" name="_METHOD" value="PUT">

                    <table class="input_table">
                        <tr>
                            <th>E-mail</th>
                            <td>
                                <?php echo h($mail); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td>
                                <?php echo h($name_f); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>
                                <?php echo h($name_l); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>
                                <?php echo h($addr); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Postal Code</th>
                            <td>
                                <?php echo h($zipcode); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>
                                <?php foreach ($countries as $key => $val): ?>
                                <?php if ($key == $country): ?>
                                <?php echo h($val); ?>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Telephone Number</th>
                            <td>
                                <?php echo h($tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>
                                <?php echo h($mb_tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>
                                <?php echo h($password); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>
                                <?php if ($gender == 1): ?>
                                Female
                                <?php elseif ($gender == 2): ?>
                                Male
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>How did you find us?</th>
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
                        <li><input type="submit" name="back" value="Back" class="backBtn"></li>
                        <li><input type="submit" name="update" value="Update" class="submitBtn"></li>
                    </ul>
                </form>
                <!-- /Edit form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>