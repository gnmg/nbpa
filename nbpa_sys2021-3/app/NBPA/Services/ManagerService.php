<?php

/**
 * @version SVN: $Id: ManagerService.php 146 2015-06-10 13:40:09Z morita $
 */
namespace NBPA\Services;

class ManagerService
{
    /**
     * ログオン認証をする.
     */
    public static function authenticateManager($userName, $userPass)
    {
        $manager = \ORM::forTable('t_manager')
            ->where('mgr_username', $userName)
            ->where('mgr_password', hash('sha256', $userPass))
            ->findOne();
        if ($manager) {
            SessionService::setManager($manager);

            return true;
        } else {
            return false;
        }
    }

    /**
     * サインアウトする.
     */
    public static function signout()
    {
        SessionService::invalidateManager();
    }

    /**
     * パスワードを更新する.
     */
    public static function updatePassword($id, $password)
    {
        $manager = \ORM::forTable('t_manager')->where('id', $id)->findOne();
        if ($manager) {
            $manager->mgr_password = hash('sha256', $password);
            $manager->updated_at   = date('Y-m-d H:i:s');
            $manager->save();

            SessionService::invalidateManager();
            SessionService::setManager($manager);

            return true;
        } else {
            return false;
        }
    }
}
