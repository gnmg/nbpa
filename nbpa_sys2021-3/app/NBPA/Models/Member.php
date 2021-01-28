<?php

/**
 * @version SVN: $Id: Member.php 124 2015-06-03 08:35:49Z morita $
 */
namespace NBPA\Models;

class Member
{
    /**
     * メンバーを全員削除する.
     */
    public static function cleanup()
    {
        \ORM::forTable('t_member_regist')
            ->delete_many();
    }

    /**
     * 指定したメールアドレスのメンバーを取得する.
     */
    public static function getMemberByMail($mail)
    {
        if (empty($mail)) {
            return false;
        }
        $member = \ORM::forTable('t_member_regist')
            ->where('mail', $mail)
            ->findOne();

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
        $member = \ORM::forTable('t_member_regist')
            ->where('member_regist_no', $memberRegistNo)
            ->findOne();

        return $member;
    }

    /**
     * MySQL の PASSWORD 関数で暗号化した文字列を取得する.
     */
    public static function getDbPassword($target)
    {
        if (empty($target)) {
            return;
        }

        $result = null;

        $sql = <<<SQL
SELECT PASSWORD(?) AS result
SQL;
        $temp = \ORM::forTable('t_member_regist')
            ->rawQuery($sql, [$target])
            ->findOne();
        if ($temp) {
            $result = $temp->result;
        }

        return $result;
    }

    /**
     * 新規にメンバーを作成するための \ORM オブジェクトを返す.
     */
    public static function createMember()
    {
        $member = \ORM::forTable('t_member_regist')->create();

        return $member;
    }

    /**
     * メンバー登録を完了する.
     */
    public static function finishMember($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return;
        }
        $member = self::getMemberByMemberRegistNo($memberRegistNo);
        if ($member) {
            $member->use_id_column('member_regist_no');
            $member->complete_flag = 1;
            $member->revision_date = date('Y-m-d H:i:s');
            $member->save();

            return $member;
        } else {
            return;
        }
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
        $member = \ORM::forTable('t_member_regist')
            ->where('member_regist_no', $memberRegistNo)
            ->findOne();
        if ($member) {
            $member->use_id_column('member_regist_no');
            $member->set_expr('password', "PASSWORD('$password')");
            $member->set_expr('password_chk', "PASSWORD('$password')");
            $member->revision_date = date('Y-m-d H:i:s');

            return $member->save();
        } else {
            return false;
        }
    }

    /**
     * 指定した範囲の国別登録人数を取得する.
     */
    public static function getMembersEachCountry($start, $end)
    {
        $query = <<<EOS
SELECT
    DATE(entry_date) AS date, pref AS country, COUNT(member_regist_no) AS count
FROM
    t_member_regist
WHERE
    DATE(entry_date) >= ? AND DATE(entry_date) <= ?
GROUP BY
    DATE(entry_date), pref
ORDER BY
    DATE(entry_date)
EOS;
        $stats = \ORM::forTable('t_member_regist')
            ->rawQuery($query, [$start, $end])
            ->findArray();

        return $stats;
    }

    /**
     * 指定したキャンペーンコードの登録人数を取得する.
     */
    public static function getMembersByCampaignCode($code, $start, $end)
    {
        $query = <<<EOS
SELECT
    DATE(entry_date) AS date, promotion_code, COUNT(member_regist_no) AS count
FROM
    t_member_regist
WHERE
    DATE(entry_date) >= ? AND DATE(entry_date) <= ?
    AND
    promotion_code = ?
GROUP BY
    DATE(entry_date), promotion_code
ORDER BY
    DATE(entry_date)
EOS;
        $stats = \ORM::forTable('t_member_regist')
            ->rawQuery($query, [$start, $end, $code])
            ->findArray();

        return $stats;
    }
}
