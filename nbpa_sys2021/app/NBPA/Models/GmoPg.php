<?php

/**
 * @version SVN: $Id: GmoPg.php 1 2018-12-16 12:20:31Z morita $
 */
namespace NBPA\Models;

class GmoPg
{
    /**
     * 新規に Result を作成するための \ORM オブジェクトを返す.
     */
    public static function createResult()
    {
        $result = \ORM::forTable('t_gmopg_result')->create();

        return $result;
    }
}
