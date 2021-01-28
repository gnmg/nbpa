<?php

/**
 * @version SVN: $Id: Payment.php 134 2015-06-08 07:53:52Z morita $
 */
namespace NBPA\Models;

class Payment
{
    const KIND_PAYDOLLAR     = 1;
    const KIND_PAYPAL        = 2;
    const KIND_BANK_TRANSFER = 3;
    const KIND_GMOPG_MCP     = 4;

    /**
     * 新規に Payment を作成するための \ORM オブジェクトを返す.
     */
    public static function createPayment()
    {
        $payment = \ORM::forTable('t_payment')->create();

        return $payment;
    }

    /**
     * 購入に成功した数を取得する.
     */
    public static function getPurchasedCount($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return 0;
        }
        $count = \ORM::forTable('t_payment')
            ->where('member_regist_no', $memberRegistNo)
            ->where('result_code', 0)
            ->count();

        return $count;
    }
}
