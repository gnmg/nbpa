<?php

/**
 * @version SVN: $Id: CookieService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

class CookieService
{
    // 30 days
    const COOKIE_EXPIRE        = 2592000;
    const COOKIE_KEY_MEMBER_NO = 'member_no';
    const COOKIE_KEY_LANGUAGE  = 'lang';
    const COOKIE_KEY_CAMPAIGN  = 'campaign';
    const COOKIE_PATH          = '/user/';

    public static function setMemberRegistNo($memberRegistNo)
    {
        setcookie(self::COOKIE_KEY_MEMBER_NO, $memberRegistNo, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
    }

    public static function getMemberRegistNo()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_MEMBER_NO])) {
            return $_COOKIE[self::COOKIE_KEY_MEMBER_NO];
        } else {
            return;
        }
    }

    public static function invalidateMemberRegistNo()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_MEMBER_NO])) {
            setcookie(self::COOKIE_KEY_MEMBER_NO, '', time() - 1800, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
        }
    }

    public static function setLanguage($lang)
    {
        setcookie(self::COOKIE_KEY_LANGUAGE, $lang, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
    }

    public static function getLanguage()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_LANGUAGE])) {
            return $_COOKIE[self::COOKIE_KEY_LANGUAGE];
        } else {
            return;
        }
    }

    public static function invalidateLanguage()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_LANGUAGE])) {
            setcookie(self::COOKIE_KEY_LANGUAGE, '', time() - 1800, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
        }
    }

    public static function setCampaign($campaign)
    {
        setcookie(self::COOKIE_KEY_CAMPAIGN, $campaign, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
    }

    public static function getCampaign()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_CAMPAIGN])) {
            return $_COOKIE[self::COOKIE_KEY_CAMPAIGN];
        } else {
            return;
        }
    }

    public static function invalidateCampaign()
    {
        if (isset($_COOKIE[self::COOKIE_KEY_CAMPAIGN])) {
            setcookie(self::COOKIE_KEY_CAMPAIGN, '', time() - 1800, self::COOKIE_PATH, self::getDomainName(), self::isSecure());
        }
    }

    private static function getDomainName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    private static function isSecure()
    {
        return !empty($_SERVER['HTTPS']);
    }
}
