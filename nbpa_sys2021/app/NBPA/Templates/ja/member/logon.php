<?php $locale     = 'ja' ?>
<?php $page_title = 'ログイン' ?>
<?php include dirname(__FILE__) . '/../partials/sys_template_header.php'; ?>

<div class="sys-body">
    <div id="container">
        <div id="content">
            <h1 class="mainTi">ログイン</h1>
            <p>マイページへのアクセスはこちら</p>
            <!-- <p style="color:red;">ネイチャーズベストフォトグラフィーアジアにご応募される皆様へ</p></br></br>
            <p style="color:red;"> ただいまシステムに不備が発生し一時的にシステムをダウンしております。大変申し訳ございませんがしばらくお待ちいただき、後日改めてご応募いただけますようお願い申し上げます。ご不便をおかけして大変申し訳ございません。
            </p> -->

            <div id="regist_form">
                <table class="loginTable">
                    <tr>
                        <td class="left">
                            <div><a href="/user/member/forgot"><span class="logonBtn">パスワードを忘れた方はこちら</span></a></div>
                            <div><a href="/user/member/signup"><span class="logonBtn">新規登録はこちらから</span></a></div>
                        </td>
                        <td class="right">

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
                            <p style="color:red;">ただいまメンテナンス中です. ご不便をおかけしますが、もうしばらくお待ちください。</p>
                            <!-- Login form -->
                            <!-- <form id="frm_login" method="post" action="/user/member/logon">
                                <div><input type="text" class="input_boxstyle" id="user_id" name="user_id" value=""
                                        placeholder="E-mail"></div>
                                <div><input type="password" class="input_boxstyle" id="password" name="password"
                                        value="" placeholder="Password"></div>
                                <div><input type="checkbox" id="eternal_login" name="eternal_login"><span
                                        class="input_table_p">ログイン状態を保存する</span></div>
                                <div id="mail_send_btn"><input type="submit" value="ログイン" class="loginBtn"></div>
                            </form> -->
                            <!-- /Login form -->

                        </td>
                    </tr>
                </table>
            </div><!-- regist_form END -->
        </div><!-- contant END -->
    </div><!-- container END -->
</div>

<?php include dirname(__FILE__) . '/../partials/sys_template_footer.php'; ?>