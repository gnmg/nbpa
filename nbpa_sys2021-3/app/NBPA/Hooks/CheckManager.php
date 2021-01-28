<?php

/**
 * Check login and set a manager.
 *
 * @version SVN: $Id: CheckManager.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Hooks;

use NBPA\Services\SessionService;

class CheckManager
{
    public static function execute()
    {
        $app     = \Slim\Slim::getInstance();
        $manager = null;

        $needLogin = true;

        // 除外リスト
        $excludeList = [
            '/manager/manager/logon',
        ];
        $haystack = $app->request->getRootUri() . $app->request->getPathInfo();
        foreach ($excludeList as $needle) {
            if (strcmp($haystack, $needle) === 0) {
                $needLogin = false;
                break;
            }
        }

        // ログインが必要な場合
        if ($needLogin) {
            $manager = SessionService::getManager();
            if (!$manager) {
                $app->redirect('/manager/manager/logon');
            }
        }

        $app->manager = $manager;
    }
}
