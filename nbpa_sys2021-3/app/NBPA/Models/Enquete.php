<?php

/**
 * @version SVN: $Id: Enquete.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Models;

class Enquete
{
    public static $enquetes = [
        'en' => [
            1 => 'Internet',
            2 => 'Facebook',
            3 => 'Newspaper',
            4 => 'Magazine',
            5 => 'Brochures',
            6 => 'Photography Club',
            7 => 'Friend',
        ],
        'ja' => [
            1 => 'インターネット',
            2 => 'フェイスブック',
            3 => '新聞',
            4 => '雑誌',
            5 => 'チラシ',
            6 => '写真クラブ',
            7 => '知人',
        ],
        'ko' => [
            1 => 'Internet',
            2 => 'Facebook',
            3 => 'Newspaper',
            4 => 'Magazine',
            5 => 'Brochures',
            6 => 'Photography Club',
            7 => 'Friend',
        ],
        'sc' => [
            1 => '因特网',
            2 => 'FACEBOOK',
            3 => '报纸',
            4 => '杂志',
            5 => '广告',
            6 => '摄影俱乐部',
            7 => '通过朋友',
        ],
        'tc' => [
            1 => '因特網',
            2 => 'FACEBOOK',
            3 => '報紙',
            4 => '雜誌',
            5 => '廣告',
            6 => '攝影俱樂部',
            7 => '通過朋友',
        ],
    ];

    public static function getEnquetes()
    {
        $app  = \Slim\Slim::getInstance();
        $lang = $app->lang;

        if (array_key_exists($lang, self::$enquetes)) {
            return self::$enquetes[$lang];
        } else {
            return self::$enquetes['en'];
        }
    }
}
