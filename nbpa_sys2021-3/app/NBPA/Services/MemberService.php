<?php

/**
 * @version SVN: $Id: MemberService.php 139 2015-06-08 16:09:58Z morita $
 */
namespace NBPA\Services;

use NBPA\Models\Member;
use NBPA\Models\Country;

class MemberService
{
    // クッキーに格納する文字列の暗号化キー
    const KEY = 'Ak8mymQAzVZjdSzr';

    // URL に埋め込む文字列の暗号化キー
    const SEC = 'cWLduiJFYVwaz3Xg';

    /**
     * メンバーを全員削除する.
     */
    public static function cleanup()
    {
        Member::cleanup();
    }

    /**
     * 暗号化された文字列を復号する.
     * Cookie に格納する member_no に使用する.
     */
    public static function decryptMemberNo($encrypted)
    {
        if (empty($encrypted)) {
            return;
        }
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::KEY), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5(self::KEY))), "\0");

        return $decrypted;
    }

    /**
     * 指定した文字列を暗号化する.
     * Cookie に格納する member_no に使用する.
     */
    public static function encryptMemberNo($target)
    {
        if (empty($target)) {
            return;
        }
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::KEY), $target, MCRYPT_MODE_CBC, md5(md5(self::KEY))));

        return $encrypted;
    }

    /**
     * エンコードされた文字列を復号する.
     * 登録、パスワード忘れで使用する.
     */
    public static function decryptString($encrypted, $time)
    {
        if (empty($encrypted) || empty($time)) {
            return;
        }
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::SEC), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($time))), "\0");

        return $decrypted;
    }

    /**
     * 指定した文字列を SEC と $time を使ってエンコードする.
     * 登録、パスワード忘れで使用する.
     */
    public static function encryptString($target, $time)
    {
        if (empty($target) || empty($time)) {
            return;
        }

        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::SEC), $target, MCRYPT_MODE_CBC, md5(md5($time))));

        return $encrypted;
    }

    /**
     * 指定したメールアドレスのメンバーを取得する.
     */
    public static function getMemberByMail($mail)
    {
        if (empty($mail)) {
            return false;
        }
        $member = Member::getMemberByMail($mail);

        return $member;
    }

    /**
     * 指定した memberRegistNo のメンバーを取得する.
     */
    public static function getMemberByMemberRegistNo($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return false;
        }
        $member = Member::getMemberByMemberRegistNo($memberRegistNo);

        return $member;
    }

    /**
     * 新規にメンバーを登録する.
     */
    public static function newMember(
        $remoteAddr,
        $mail,
        $name_l,
        $name_f,
        $zipcode,
        $country,
        $addr,
        $tel,
        $mb_tel,
        $password,
        $gender,
        $complete,
        $enquete,
        $status,
        $promo_code
    ) {
        $member = Member::createMember();

        if (empty($enquete)) {
            $enquete = null;
        } else {
            $enquete = implode(',', $enquete);
        }

        $member->ip            = $remoteAddr;
        $member->mail          = $mail;
        $member->mail_chk      = $mail;
        $member->name_s        = $name_l;
        $member->name_m        = $name_f;
        $member->zipcode1      = $zipcode;
        $member->pref          = $country;
        $member->apname        = $addr;
        $member->tel           = $tel;
        $member->mb_tel        = $mb_tel;
        $member->sex           = $gender;
        $member->complete_flag = $complete;
        $member->enquete1      = $enquete;
        $member->status        = $status;
        $member->entry_date    = date('Y-m-d H:i:s');
        $member->revision_date = date('Y-m-d H:i:s');

        $member->set_expr('password', "PASSWORD('$password')");
        $member->set_expr('password_chk', "PASSWORD('$password')");

        $member->promotion_code = $promo_code;

        if ($member->save()) {
            return self::getMemberByMail($mail);
        }

        return false;
    }

    /**
     * メンバー情報を更新する.
     */
    public static function updateMember(
        $memberRegistNo,
        $remoteAddr,
        $mail,
        $name_l,
        $name_f,
        $zipcode,
        $country,
        $addr,
        $tel,
        $mb_tel,
        $password,
        $gender,
        $enquete
    ) {
        $member = Member::getMemberByMemberRegistNo($memberRegistNo);
        if ($member) {
            if (empty($enquete)) {
                $enquete = null;
            } else {
                $enquete = implode(',', $enquete);
            }

            $member->ip            = $remoteAddr;
            $member->mail          = $mail;
            $member->mail_chk      = $mail;
            $member->name_s        = $name_l;
            $member->name_m        = $name_f;
            $member->zipcode1      = $zipcode;
            $member->pref          = $country;
            $member->apname        = $addr;
            $member->tel           = $tel;
            $member->mb_tel        = $mb_tel;
            $member->sex           = $gender;
            $member->enquete1      = $enquete;
            $member->revision_date = date('Y-m-d H:i:s');

            if (!empty($password)) {
                $member->set_expr('password', "PASSWORD('$password')");
                $member->set_expr('password_chk', "PASSWORD('$password')");
            }

            $member->use_id_column('member_regist_no');
            $member->save();
        }
    }

    /**
     * メンバー登録を完了する.
     */
    public static function finishMember($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return;
        }
        $member = Member::finishMember($memberRegistNo);

        return $member;
    }

    /**
     * 指定した memberRegistNo のメンバーのパスワードを更新する.
     */
    public static function updateMemberPassword($memberRegistNo, $password)
    {
        if (empty($memberRegistNo)) {
            return false;
        }
        if (empty($password)) {
            return false;
        }

        return Member::updateMemberPassword($memberRegistNo, $password);
    }

    /**
     * 指定したメールアドレスとパスワードでユーザー認証する.
     */
    public static function authenticateMember($mail, $password)
    {
        if (empty($mail)) {
            return false;
        }
        if (empty($password)) {
            return false;
        }

        $result = false;

        $member = Member::getMemberByMail($mail);
        if ($member) {
            $dbPassword = Member::getDbPassword($password);
            if ($dbPassword) {
                if (strcmp($dbPassword, $member->password) == 0) {
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * 総メンバー数を取得する.
     */
    public static function getTotalMemberCount()
    {
        $count = \ORM::forTable('t_member_regist')->count();

        return $count;
    }

    /**
     * 国別のメンバー数を取得する.
     */
    public static function getMemberCountEachCountry()
    {
        $members = \ORM::forTable('t_member_regist')
            ->select('pref', 'countryId')
            ->select('sex', 'gender')
            ->selectExpr('COUNT(member_regist_no)', 'count')
            ->groupBy('pref')->groupBy('sex')
            ->findMany();

        $results = [];

        foreach ($members as $member) {
            if (!isset($results[$member->countryId])) {
                $results[$member->countryId] = [
                    'countryName' => '',
                    'male'        => 0,
                    'female'      => 0,
                ];
            }
            foreach (Country::$countries as $countryId => $countryName) {
                if ($member->countryId == $countryId) {
                    $results[$member->countryId]['countryName'] = $countryName;
                }
            }
            if ($member->gender == 1) {
                $results[$member->countryId]['female'] = $member->count;
            }
            if ($member->gender == 2) {
                $results[$member->countryId]['male'] = $member->count;
            }
        }

        return $results;
    }
}
