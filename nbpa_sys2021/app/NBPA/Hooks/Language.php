<?php

/**
 * @version SVN: $Id: Language.php 163 2015-09-08 06:01:23Z morita $
 */
namespace NBPA\Hooks;

use NBPA\Services\CookieService;

class Language
{
    /**
     * lang パラメータで指定された言語を Cookie に保存する.
     * 無指定の場合は en (英語) とする.
     */
    public static function execute()
    {
        $app = \Slim\Slim::getInstance();

        $lang = $app->request->params('lang');

        if (isset($lang)) {
            if (in_array($lang, ['en', 'ja', 'ko', 'ru', 'sc', 'tc', 'test'])) {
                CookieService::setLanguage($lang);
            } else {
                $lang = 'en';
                CookieService::setLanguage($lang);
            }
        } else {
            $lang = CookieService::getLanguage();
            if (!isset($lang)) {
                $lang = 'en';
                CookieService::setLanguage($lang);
            }
        }

        $app->lang = $lang;
    }
}
