<?php
/**
 * Entry point
 *
 * @version SVN: $Id$
 */
define('APP_ROOT', __DIR__.'/../../nbpa_sys2021-3');

require_once APP_ROOT.'/vendor/autoload.php';
require_once APP_ROOT.'/app/bootstrap_manager.php';
require_once APP_ROOT.'/app/dispatcher_manager.php';

$app->run();
