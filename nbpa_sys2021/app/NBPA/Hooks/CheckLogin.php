<?php

/**
 * Check login and set a user.
 *
 * @version SVN: $Id: CheckLogin.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Hooks;

use NBPA\Services\MemberService;
use NBPA\Services\CookieService;
use NBPA\Services\SessionService;

class CheckLogin
{
    public static function execute()
    {
        $app    = \Slim\Slim::getInstance();
        $member = null;

        $needLogin = true;

        // 除外リスト
        $excludeList = [
            '/user/member/logon',
            '/user/member/forgot',
            '/user/member/forgot/complete',
            '/user/member/signup',
            '/user/member/signup/complete',
            '/user/member/verification',
            '/user/member/verification/complete',
            '/user/member/resetpassword',
            '/user/member/resetpassword/complete',

            '/user/payment/success',
            '/user/payment/fail',
            '/user/payment/cancel',
            '/user/payment/datafeed',
            '/user/payment/paypalIPN',

            '/user/member/cleanup',
        ];
        $haystack = $app->request->getRootUri() . $app->request->getPathInfo();
        foreach ($excludeList as $needle) {
            if (strcmp($haystack, $needle) === 0) {
                $needLogin = false;
                break;
            }
        }

        // Cookie を持っている場合
        $encrypted = CookieService::getMemberRegistNo();
        if ($encrypted) {
            $memberRegistNo = MemberService::decryptMemberNo($encrypted);
            if ($memberRegistNo) {
                $member = MemberService::getMemberByMemberRegistNo($memberRegistNo);
            }
        }

        // ログインが必要な場合
        if ($needLogin) {
            $memberRegistNo = SessionService::getMemberRegistNo();
            if ($memberRegistNo) {
                $member = MemberService::getMemberByMemberRegistNo($memberRegistNo);
            }
            if (!$member) {
                $app->redirect('/user/member/logon');
            }
        }

        $app->member = $member;
    }
}
