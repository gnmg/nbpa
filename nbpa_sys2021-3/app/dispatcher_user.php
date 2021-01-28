<?php

/**
 * Routing commands.
 *
 * @version SVN: $Id: dispatcher_user.php 141 2015-06-09 02:38:47Z morita $
 */

// session
session_cache_limiter(false);
session_start();

// middleware
$app->add(new \Slim\Middleware\ContentTypes());

// hooks
$app->hook('slim.before', '\NBPA\Hooks\Logger::execute');
$app->hook('slim.before.dispatch', '\NBPA\Hooks\Language::execute');
$app->hook('slim.before.dispatch', '\NBPA\Hooks\CheckLogin::execute');

$notForProductionList = ['/user/member/clean'];
if ($env === 'production') {
    $haystack = $app->request->getRootUri() . $app->request->getPathInfo();
    foreach ($notForProductionList as $needle) {
        if (strcmp($haystack, $needle) === 0) {
            $app->halt(404);
        }
    }
}

// routing

//---------------------------------------------
// ログオン画面を表示する。
//---------------------------------------------
$app->get(
    '/member/logon',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::logon($app);
    }
);

//---------------------------------------------
// ログオン認証をする。
//---------------------------------------------
$app->post(
    '/member/logon',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::authenticateMember($app);
    }
);

//---------------------------------------------
// ホーム画面を表示する。
//---------------------------------------------
$app->get(
    '/member/home',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::home($app);
    }
);

//---------------------------------------------
// STRIPE PAYMENT
//---------------------------------------------
$app->post(
    '/stripe/payment',
    function () use ($app) {
        return \NBPA\Controllers\StripeController::payment($app);
    }
);

//---------------------------------------------
// サインオフする。
//---------------------------------------------
$app->get(
    '/member/signoff',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::signoff($app);
    }
);

//---------------------------------------------
// パスワード忘れフォームを表示する。
//---------------------------------------------
$app->get(
    '/member/forgot',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::forgot($app);
    }
);

//---------------------------------------------
// パスワード再設定メールを送信する。
//---------------------------------------------
$app->post(
    '/member/forgot',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::forgotProcess($app);
    }
);

//-----------------------------------------------
// パスワード再設定メール送信完了画面を表示する。
//-----------------------------------------------
$app->get(
    '/member/forgot/complete',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::forgotComplete($app);
    }
);

//---------------------------------------------
// パスワード再設定画面を表示する。
//---------------------------------------------
$app->get(
    '/member/resetpassword',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::resetpassword($app);
    }
);

//---------------------------------------------
// パスワードを再設定する。
//---------------------------------------------
$app->post(
    '/member/resetpassword',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::resetpasswordProcess($app);
    }
);

//---------------------------------------------
// パスワード再設定完了画面を表示する。
//---------------------------------------------
$app->get(
    '/member/resetpassword/complete',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::resetpasswordComplete($app);
    }
);

//---------------------------------------------
// サインアップ画面を表示する。
//---------------------------------------------
$app->get(
    '/member/signup',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::signup($app);
    }
);

//---------------------------------------------
// サインアップ確認画面を表示する。
//---------------------------------------------
$app->post(
    '/member/signup',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::signupConfirmation($app);
    }
);

//---------------------------------------------
// サインアップ処理。
//---------------------------------------------
$app->put(
    '/member/signup',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::signupProcess($app);
    }
);

//---------------------------------------------
// 仮登録完了画面を表示する。
//---------------------------------------------
$app->get(
    '/member/signup/complete',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::signupComplete($app);
    }
);

//---------------------------------------------
// メールアドレス確認画面を表示する。
//---------------------------------------------
$app->get(
    '/member/verification',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::verification($app);
    }
);

//---------------------------------------------
// メールアドレス確認完了画面を表示する。
//---------------------------------------------
$app->get(
    '/member/verification/complete',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::verificationComplete($app);
    }
);

//---------------------------------------------
// メンバー編集画面を表示する。
//---------------------------------------------
$app->get(
    '/member/edit',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::edit($app);
    }
);

//-----------------------------------------------------
// メンバー編集確認画面を表示する。
//-----------------------------------------------------
$app->post(
    '/member/edit',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::editConfirmation($app);
    }
);

//-------------------------------------------------------
// メンバー編集処理。
//-------------------------------------------------------
$app->put(
    '/member/edit',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::editProcess($app);
    }
);

//---------------------------------------------
// メンバー編集完了画面を表示する。
//---------------------------------------------
$app->get(
    '/member/edit/complete',
    function () use ($app) {
        return \NBPA\Controllers\MemberController::editComplete($app);
    }
);

//---------------------------------------------
// メンバーを全員削除する。
//---------------------------------------------
if ($env !== 'production') {
    $app->get(
        '/member/cleanup',
        function () use ($app) {
            return \NBPA\Controllers\MemberController::cleanup($app);
        }
    );
}

//---------------------------------------------
// 決済成功画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/success',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::success($app);
    }
);

//---------------------------------------------
// 決済失敗画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/fail',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::fail($app);
    }
);

//---------------------------------------------
// 決済キャンセル画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/cancel',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::cancel($app);
    }
);

//---------------------------------------------
// PayDollar データフィードを受信する。
//---------------------------------------------
$app->post(
    '/payment/datafeed',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::datafeed($app);
    }
);

//---------------------------------------------
// PayPal IPN を受信する。
//---------------------------------------------
$app->post(
    '/payment/paypalIPN',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::paypalIPN($app);
    }
);

//---------------------------------------------
// GMO PG 結果を受信する。
//---------------------------------------------
$app->post(
    '/gmopg/result',
    function () use ($app) {
        return \NBPA\Controllers\PaymentController::gmoPgResult($app);
    }
);

//---------------------------------------------
// 作品応募画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/entry',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::entry($app);
    }
);

//---------------------------------------------
// 作品応募確認画面を表示する。
//---------------------------------------------
$app->post(
    '/entry/entry',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::entryConfirmation($app);
    }
);

//---------------------------------------------
// 作品応募処理。
//---------------------------------------------
$app->put(
    '/entry/entry',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::entryProcess($app);
    }
);

//---------------------------------------------
// 作品応募完了画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/complete',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::entryComplete($app);
    }
);

//---------------------------------------------
// 応募作品の一覧を表示する。
//---------------------------------------------
$app->get(
    '/entry/list/:categoryId',
    function ($categoryId) use ($app) {
        return \NBPA\Controllers\EntryController::listByCategory($app, $categoryId);
    }
);

//---------------------------------------------
// 応募作品の一覧を更新する。
//---------------------------------------------
$app->post(
    '/entry/list/:categoryId',
    function ($categoryId) use ($app) {
        return \NBPA\Controllers\EntryController::updateList($app, $categoryId);
    }
);

//---------------------------------------------
// 画像を表示する。
//---------------------------------------------
$app->get(
    '/entry/image/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\EntryController::image($app, $id);
    }
);

//---------------------------------------------
// ハイレゾ作品の応募フォームを表示する。
//---------------------------------------------
$app->get(
    '/entry/hires/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\EntryController::hires($app, $id);
    }
);

//---------------------------------------------
// ハイレゾ作品応募確認画面を表示する。
//---------------------------------------------
$app->post(
    '/entry/hires',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::hiresConfirmation($app);
    }
);

//---------------------------------------------
// ハイレゾ作品応募処理。
//---------------------------------------------
$app->put(
    '/entry/hires',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::hiresProcess($app);
    }
);

//---------------------------------------------
// ハイレゾ作品応募完了画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/hirescomplete',
    function () use ($app) {
        return \NBPA\Controllers\EntryController::hiresComplete($app);
    }
);
