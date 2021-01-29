<?php

/**
 * @version SVN: $Id: Datafeed.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Models;

class Datafeed
{
    /**
     * 新規に Datafeed を作成するための \ORM オブジェクトを返す.
     */
    public static function createDatafeed()
    {
        $datafeed = \ORM::forTable('t_paydollar_datafeed')->create();

        return $datafeed;
    }

    /**
     * 購入に成功した数を取得する.
     */
    public static function getPurchasedCount($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return 0;
        }
        $count = \ORM::forTable('t_paydollar_datafeed')
            ->where('member_regist_no', $memberRegistNo)
            ->where('pd_successcode', 0)
            ->count();

        return $count;
    }
}
