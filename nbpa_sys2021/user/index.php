<?php
/**
 * Entry point
 *
 * @version SVN: $Id$
 */
define('APP_ROOT', __DIR__ . '/../../nbpa_sys2020');

require_once APP_ROOT . '/vendor/autoload.php';
require_once APP_ROOT . '/app/bootstrap_user.php';
require_once APP_ROOT . '/app/dispatcher_user.php';

$app->run();
