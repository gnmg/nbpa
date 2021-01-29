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

// routing

//---------------------------------------------
// メンバー統計情報を表示する。
//---------------------------------------------
$app->get(
    '/members/',
    function () use ($app) {
        return \NBPA\Controllers\Campaign\CampaignController::members($app);
    }
);
