<?php
/**
 * @version SVN: $Id: SettingService.php 162 2015-09-02 07:19:37Z morita $
 */
namespace NBPA\Services;

class SettingService
{
    /**
     * 開催期間開始を取得する.
     */
    public static function getTermStart()
    {
        return self::_get('TERM_START');
    }

    /**
     * 開催期間終了を取得する.
     */
    public static function getTermEnd()
    {
        return self::_get('TERM_END');
    }

    /**
     * 開催期間タイムゾーンを取得する.
     */
    public static function getTermTimezone()
    {
        return self::_get('TERM_TIMEZONE');
    }

    /**
     * 支払い期間開始を取得する.
     */
    public static function getPayStart()
    {
        return self::_get('PAY_START');
    }

    /**
     * 支払い期間終了を取得する.
     */
    public static function getPayEnd()
    {
        return self::_get('PAY_END');
    }

    /**
     * 支払い期間タイムゾーンを取得する.
     */
    public static function getPayTimezone()
    {
        return self::_get('PAY_TIMEZONE');
    }

    private static function _get($key)
    {
        $setting = \ORM::forTable('t_settings')
            ->where('settings_key', $key)
            ->findOne();

        if ($setting) {
            return $setting->settings_val;
        } else {
            return null;
        }
    }

    /**
     * 現在が開催期間中か判定する.
     */
    public static function inTerm($termStart, $termEnd, $timezone)
    {
        $inTerm = 0;

        if ($termStart && $termEnd && $timezone) {
            $now = new \DateTime();
            $now->setTimeZone(new \DateTimeZone($timezone));

            $start = new \DateTime($termStart);
            $start->setTimeZone(new \DateTimeZone($timezone));

            $end = new \DateTime($termEnd);
            $end->setTimeZone(new \DateTimeZone($timezone));

            if ($now > $start && $now < $end) {
                $inTerm = 1;
            } else {
                $inTerm = 0;
            }
        }

        return $inTerm;
    }

    /**
     * 現在が支払い期間中か判定する.
     */
    public static function inPay($termStart, $termEnd, $timezone)
    {
        $inTerm = 0;

        if ($termStart && $termEnd && $timezone) {
            $now = new \DateTime();
            $now->setTimeZone(new \DateTimeZone($timezone));

            $start = new \DateTime($termStart);
            $start->setTimeZone(new \DateTimeZone($timezone));

            $end = new \DateTime($termEnd);
            $end->setTimeZone(new \DateTimeZone($timezone));

            if ($now > $start && $now < $end) {
                $inTerm = 1;
            } else {
                $inTerm = 0;
            }
        }

        return $inTerm;
    }
}
