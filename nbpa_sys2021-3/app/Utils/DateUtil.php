<?php

/**
 * Utility class of date.
 *
 * @version SVN: $Id: DateUtil.php 113 2015-05-20 08:23:04Z morita $
 */
namespace Utils;

class DateUtil
{
    /**
     * 指定した期間の日付の配列を取得する.
     */
    public static function dateList($from, $to)
    {
        $result = [];

        $datetime = new \DateTime($from);
        while (true) {
            $date     = $datetime->format('Y-m-d');
            $result[] = $date;
            $datetime = $datetime->modify('+1 day');
            if ($to < $datetime->format('Y-m-d')) {
                break;
            }
        }

        return $result;
    }
}
