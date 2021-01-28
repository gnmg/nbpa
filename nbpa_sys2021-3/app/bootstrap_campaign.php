<?php

/**
 * Bootstrap a application.
 *
 * @version SVN: $Id: bootstrap_manager.php 94 2015-04-10 10:37:17Z morita $
 */

// timezone
date_default_timezone_set('Asia/Tokyo');

// environment
$env = getenv('APP_ENV');
$env = empty($env) ? 'production' : $env;
$app = new \Slim\Slim(['mode' => $env]);
$app->setName('NBPA');

require APP_ROOT . '/config/settings.php';

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// connection to DB
\NBPA\Services\DbService::configure();
