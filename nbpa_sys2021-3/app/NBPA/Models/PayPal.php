<?php

/**
 * @version SVN: $Id: PayPal.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Models;

class PayPal
{
    /**
     * 新規に IPN を作成するための \ORM オブジェクトを返す.
     */
    public static function createIPN()
    {
        $ipn = \ORM::forTable('t_paypal_ipn')->create();

        return $ipn;
    }
}
