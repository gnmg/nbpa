<?php $locale     = 'sc' ?>
<?php $page_title = 'Confirm' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">

    <div id="container">
        <div id="content">
            <h1 class="mainTi">编辑</h1>
            <div id="regist_form">



                <!-- Edit form -->
                <form id="frm_edit" method="post" action="/user/member/edit">
                    <input type="hidden" name="_METHOD" value="PUT">

                    <table class="input_table">
                        <tr>
                            <th>电子邮件地址</th>
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
                            <th>地址</th>
                            <td>
                                <?php echo h($addr); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>邮编号码</th>
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
                            <th>电话号码</th>
                            <td>
                                <?php echo h($tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>手机号码</th>
                            <td>
                                <?php echo h($mb_tel); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>密码</th>
                            <td>
                                <?php echo h($password); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>性别 </th>
                            <td>
                                <?php if ($gender == 1): ?>
                                女性
                                <?php elseif ($gender == 2): ?>
                                男性
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>怎么知道我们的活动</th>
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
                        <li><input type="submit" name="back" value="返回" class="backBtn"></li>
                        <li><input type="submit" name="update" value="更新" class="submitBtn"></li>
                    </ul>
                </form>
                <!-- /Edit form -->
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>