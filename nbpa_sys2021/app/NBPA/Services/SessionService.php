<?php

/**
 * @version SVN: $Id: SessionService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

class SessionService
{
    const SSN_KEY_MEMBER_NO = 'member_no';
    const SSN_KEY_MANAGER   = 'manager';

    /**
     * メンバー登録番号をセッションに保存する.
     */
    public static function setMemberRegistNo($memberRegistNo)
    {
        $_SESSION[self::SSN_KEY_MEMBER_NO] = $memberRegistNo;
    }

    /**
     * メンバー登録番号をセッションから取得する.
     */
    public static function getMemberRegistNo()
    {
        if (isset($_SESSION[self::SSN_KEY_MEMBER_NO])) {
            return $_SESSION[self::SSN_KEY_MEMBER_NO];
        } else {
            return;
        }
    }

    /**
     * メンバー登録番号を管理するセッションを破棄する.
     */
    public static function invalidateMemberRegistNo()
    {
        if (isset($_SESSION[self::SSN_KEY_MEMBER_NO])) {
            unset($_SESSION[self::SSN_KEY_MEMBER_NO]);
        }
    }

    /**
     * 管理者情報をセッションに保存する.
     */
    public static function setManager($manager)
    {
        $_SESSION[self::SSN_KEY_MANAGER] = $manager;
    }

    /**
     * 管理者情報をセッションから取得する.
     */
    public static function getManager()
    {
        if (isset($_SESSION[self::SSN_KEY_MANAGER])) {
            return $_SESSION[self::SSN_KEY_MANAGER];
        } else {
            return;
        }
    }

    /**
     * 管理者情報を管理するセッションを破棄する.
     */
    public static function invalidateManager()
    {
        if (isset($_SESSION[self::SSN_KEY_MANAGER])) {
            unset($_SESSION[self::SSN_KEY_MANAGER]);
        }
    }
}
