<?php

/**
 * Routing commands.
 *
 * @version SVN: $Id: dispatcher_manager.php 146 2015-06-10 13:40:09Z morita $
 */

// session
session_cache_limiter(false);
session_start();

// middleware
$app->add(new \Slim\Middleware\ContentTypes());

// hooks
$app->hook('slim.before', '\NBPA\Hooks\Logger::execute');
$app->hook('slim.before.dispatch', '\NBPA\Hooks\CheckManager::execute');

// routing

//---------------------------------------------
// ログオン画面を表示する。
//---------------------------------------------
$app->get(
    '/manager/logon',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::logon($app);
    }
);

//---------------------------------------------
// ログオン認証をする。
//---------------------------------------------
$app->post(
    '/manager/logon',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::authenticateManager($app);
    }
);

//---------------------------------------------
// サインアウトする。
//---------------------------------------------
$app->get(
    '/manager/signout',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::signout($app);
    }
);

//---------------------------------------------
// パスワード変更画面を表示する。
//---------------------------------------------
$app->get(
    '/manager/password',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::password($app);
    }
);

//---------------------------------------------
// パスワードを更新する。
//---------------------------------------------
$app->post(
    '/manager/password',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::updatePassword($app);
    }
);

//---------------------------------------------
// ダッシュボード画面を表示する。
//---------------------------------------------
$app->get(
    '/manager/dashboard',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ManagerController::dashboard($app);
    }
);

//---------------------------------------------
// 会員一覧画面を表示する。
//---------------------------------------------
$app->get(
    '/member/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\MemberController::index($app);
    }
);

//---------------------------------------------
// 会員詳細画面を表示する。
//---------------------------------------------
$app->get(
    '/member/show/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\Manager\MemberController::show($app, $id);
    }
);

//---------------------------------------------
// 会員編集画面を表示する。
//---------------------------------------------
$app->get(
    '/member/edit/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\Manager\MemberController::edit($app, $id);
    }
);

//---------------------------------------------
// 会員情報を更新する。
//---------------------------------------------
$app->post(
    '/member/edit',
    function () use ($app) {
        return \NBPA\Controllers\Manager\MemberController::save($app);
    }
);

//---------------------------------------------
// 課金一覧画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::index($app);
    }
);

//---------------------------------------------
// 課金ステータスを更新する。
//---------------------------------------------
$app->post(
    '/payment/chgStatus',
    function () use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::chgStatus($app);
    }
);

//---------------------------------------------
// 課金詳細画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/show/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::show($app, $id);
    }
);

//---------------------------------------------
// 銀行振込画面を表示する。
//---------------------------------------------
$app->get(
    '/payment/addBank',
    function () use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::addBank($app);
    }
);

//---------------------------------------------
// 銀行振込確認画面を表示する。
//---------------------------------------------
$app->post(
    '/payment/confirmBank',
    function () use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::confirmBank($app);
    }
);

//---------------------------------------------
// 銀行振込を保存する.
//---------------------------------------------
$app->post(
    '/payment/saveBank',
    function () use ($app) {
        return \NBPA\Controllers\Manager\PaymentController::saveBank($app);
    }
);

//---------------------------------------------
// 応募一覧画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\EntryController::index($app);
    }
);

//---------------------------------------------
// 応募詳細画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/show/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::show($app, $uid, $id);
    }
);

//---------------------------------------------
// 応募編集画面を表示する。
//---------------------------------------------
$app->get(
    '/entry/edit/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::edit($app, $uid, $id);
    }
);

//---------------------------------------------
// 応募情報を更新する。
//---------------------------------------------
$app->post(
    '/entry/edit',
    function () use ($app) {
        return \NBPA\Controllers\Manager\EntryController::save($app);
    }
);

//---------------------------------------------
// 画像を表示する。
//---------------------------------------------
$app->get(
    '/entry/image/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::image($app, $uid, $id);
    }
);

//---------------------------------------------
// 画像を表示する。
//---------------------------------------------
$app->get(
    '/entry/thumbnail/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::thumbnail($app, $uid, $id);
    }
);

//---------------------------------------------
// 画像をダウンロードする。
//---------------------------------------------
$app->get(
    '/entry/download/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::download($app, $uid, $id);
    }
);

//---------------------------------------------
// ハイレゾ画像をダウンロードする。
//---------------------------------------------
$app->get(
    '/entry/hiresdownload/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::downloadHiRes($app, $uid, $id);
    }
);

//---------------------------------------------
// RAW 画像をダウンロードする。
//---------------------------------------------
$app->get(
    '/entry/rawdownload/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\EntryController::downloadRaw($app, $uid, $id);
    }
);

//---------------------------------------------
// メンバー統計情報を表示する。
//---------------------------------------------
$app->get(
    '/analytics/members',
    function () use ($app) {
        return \NBPA\Controllers\Manager\AnalyticsController::members($app);
    }
);

//---------------------------------------------
// 応募統計情報を表示する。
//---------------------------------------------
$app->get(
    '/analytics/entries',
    function () use ($app) {
        return \NBPA\Controllers\Manager\AnalyticsController::entries($app);
    }
);

//---------------------------------------------
// メール抽出画面を表示する。
//---------------------------------------------
$app->get(
    '/communication/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\CommunicationController::index($app);
    }
);

//---------------------------------------------
// メールを抽出する。
//---------------------------------------------
$app->post(
    '/communication/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\CommunicationController::pick($app);
    }
);

//---------------------------------------------
// 審査員一覧画面を表示する.
//---------------------------------------------
$app->get(
    '/judge/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\JudgeController::index($app);
    }
);

//---------------------------------------------
// 審査員編集画面を表示する。
//---------------------------------------------
$app->get(
    '/judge/edit/:id',
    function ($id) use ($app) {
        return \NBPA\Controllers\Manager\JudgeController::edit($app, $id);
    }
);

//---------------------------------------------
// 審査員情報を更新する。
//---------------------------------------------
$app->post(
    '/judge/edit',
    function () use ($app) {
        return \NBPA\Controllers\Manager\JudgeController::save($app);
    }
);

//---------------------------------------------
// 審査一覧画面を表示する。
//---------------------------------------------
$app->get(
    '/contest/index',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ContestController::index($app);
    }
);

//---------------------------------------------
// 画像を表示する。
//---------------------------------------------
$app->get(
    '/contest/image/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\ContestController::image($app, $uid, $id);
    }
);

//---------------------------------------------
// 画像を表示する。
//---------------------------------------------
$app->get(
    '/contest/thumbnail/:uid/:id',
    function ($uid, $id) use ($app) {
        return \NBPA\Controllers\Manager\ContestController::thumbnail($app, $uid, $id);
    }
);

//---------------------------------------------
// ポイントを保存する。
//---------------------------------------------
$app->post(
    '/contest/save',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ContestController::save($app);
    }
);

//---------------------------------------------
// コンテストの設定を表示する.
//---------------------------------------------
$app->get(
    '/contest/setting',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ContestController::showSetting($app);
    }
);

//---------------------------------------------
// コンテストの設定を更新する.
//---------------------------------------------
$app->post(
    '/contest/setting',
    function () use ($app) {
        return \NBPA\Controllers\Manager\ContestController::saveSetting($app);
    }
);
