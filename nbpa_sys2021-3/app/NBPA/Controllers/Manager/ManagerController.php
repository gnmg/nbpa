<?php

/**
 * @version SVN: $Id: ManagerController.php 161 2015-09-02 07:02:37Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Services\ManagerService;
use NBPA\Services\SettingService;
use NBPA\Services\MemberService;
use NBPA\Services\EntryService;
use NBPA\Services\SessionService;

class ManagerController
{
    /**
     * ログオン画面を表示する.
     *
     * GET /manager/logon
     */
    public static function logon($app)
    {
        if ($app->manager) {
            $app->redirect('/manager/manager/dashboard');
        } else {
            $app->render(
                'manager/manager/logon.php',
                [
                    'app' => $app,
                ]
            );
        }
    }

    /**
     * ログオン認証をする.
     *
     * POST /manager/logon
     */
    public static function authenticateManager($app)
    {
        $userName = $app->request->post('user_name');
        $userPass = $app->request->post('user_pass');

        if (ManagerService::authenticateManager($userName, $userPass)) {
            $app->redirect('/manager/manager/dashboard');
        } else {
            $app->flash('error', 'User Name or User Password is not correct.');
            $app->redirect('/manager/manager/logon');
        }
    }

    /**
     * サインアウトする.
     *
     * GET /manager/signout
     */
    public static function signout($app)
    {
        ManagerService::signout();

        $app->redirect('/manager/manager/logon');
    }

    /**
     * パスワード変更画面を表示する.
     *
     * GET /manager/password
     */
    public static function password($app)
    {
        $app->render(
            'manager/manager/password.php',
            [
                'app' => $app,
            ]
        );
    }

    /**
     * パスワードを更新する.
     *
     * POST /manager/password
     */
    public static function updatePassword($app)
    {
        $currentPassword = $app->request->post('currentPassword');
        $newPassword     = $app->request->post('newPassword');
        $verifyPassword  = $app->request->post('verifyPassword');

        $newPassword    = trim($newPassword);
        $verifyPassword = trim($verifyPassword);

        $manager = SessionService::getManager();
        if ($manager) {
            $userName = $manager->mgr_username;
            $userPass = $currentPassword;
            if (ManagerService::authenticateManager($userName, $userPass)) {
                if (strcmp($newPassword, $verifyPassword) === 0) {
                    if (strlen($newPassword) >= 8 && strlen($newPassword) <= 20) {
                        $managerId = $manager->id;
                        if (ManagerService::updatePassword($managerId, $newPassword)) {
                            $app->flash('message', 'Success to update your password.');
                        } else {
                            $app->flash('errors', 'Failed to update your password.');
                        }
                        $app->redirect('/manager/manager/password');
                    } else {
                        $app->flash('errors', 'Your password needs to be between 8 and 20 characters.');
                        $app->redirect('/manager/manager/password');
                    }
                } else {
                    $app->flash('errors', 'New password and verify password does not match.');
                    $app->redirect('/manager/manager/password');
                }
            } else {
                $app->flash('errors', 'Current password is incorrect.');
                $app->redirect('/manager/manager/password');
            }
        }
    }

    /**
     * ダッシュボード画面を表示する.
     *
     * GET /manager/dashboard
     */
    public static function dashboard($app)
    {
        $termStart = SettingService::getTermStart();
        $termEnd   = SettingService::getTermEnd();
        $timezone  = SettingService::getTermTimezone();

        $memberCount = MemberService::getTotalMemberCount();
        $entryCount  = EntryService::getTotalEntryCount();

        $memberCountries = MemberService::getMemberCountEachCountry();
        $entryCountries  = EntryService::getEntryCountEachCountry();

        $app->render(
            'manager/manager/dashboard.php',
            [
                'app' => $app,

                'termStart' => $termStart,
                'termEnd'   => $termEnd,
                'timezone'  => $timezone,

                'memberCount' => $memberCount,
                'entryCount'  => $entryCount,

                'memberCountries' => $memberCountries,
                'entryCountries'  => $entryCountries,
            ]
        );
    }
}
