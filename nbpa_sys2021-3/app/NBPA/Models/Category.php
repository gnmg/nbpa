<?php

/**
 * @version SVN: $Id: Category.php 163 2015-09-08 06:01:23Z morita $
 */
namespace NBPA\Models;

class Category
{
    public static $categories = [
        'en' => [
            '1' => 'WILDLIFE',
            '2' => 'LANDSCAPES',
            '3' => 'OCEANS',
            '4' => 'BIRDS',
            '5' => 'SMALL WORLD',
            '6' => 'MOVIES',
            '7' => 'JUNIOR',
        ],
        'ja' => [
            '1' => 'ワイルドライフ',
            '2' => '風景',
            '3' => '海',
            '4' => '鳥',
            '5' => 'スモールワールド',
            '6' => '動画',
            '7' => 'ジュニア',
        ],
        'ko' => [
            '1' => '와일드 라이프',
            '2' => '풍경',
            '3' => '바다',
            '4' => '조류',
            '5' => '스몰 월드',
            '6' => '영화 산업',
            '7' => '청소년',
        ],
        'sc' => [
            '1' => '野生动物',
            '2' => '风景',
            '3' => '海',
            '4' => '鸟',
            '5' => '微观世界',
            '6' => '电影',
            '7' => '青少年组',
        ],
        'tc' => [
            '1' => '野生動物',
            '2' => '風景',
            '3' => '海',
            '4' => '鳥',
            '5' => '微觀世界',
            '6' => '電影',
            '7' => '青少年',
        ],
        'ru' => [
            '1' => 'Дикая природа',
            '2' => 'Пейзаж',
            '3' => 'Океан',
            '4' => 'Птицы',
            '5' => 'Маленький мир',
            '6' => 'Видео',
            '7' => 'Юный фотограф',
        ],
    ];

    public static function getCategories()
    {
        $app  = \Slim\Slim::getInstance();
        $lang = $app->lang;

        if (array_key_exists($lang, self::$categories)) {
            if ($lang == 'test') {
                $lang = 'en';
            }

            return self::$categories[$lang];
        } else {
            return self::$categories['en'];
        }
    }

    /**
     * カテゴリ名を取得する.
     */
    public static function getCategoryName($categoryId, $lang = 'en')
    {
        if (array_key_exists($lang, self::$categories)) {
            if ($lang == 'test') {
                $lang = 'en';
            }
            $categories = self::$categories[$lang];
        } else {
            $categories = self::$categories['en'];
        }

        return $categories[$categoryId];
    }
}
