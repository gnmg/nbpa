<?php

/**
 * @version SVN: $Id: TemplateService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

class TemplateService
{
    public static function getTemplatePath($name)
    {
        if (empty($name)) {
            return;
        }
        $app  = \Slim\Slim::getInstance();
        $lang = $app->lang;

        $result = $lang . DIRECTORY_SEPARATOR . $name;

        return $result;
    }

    public static function getTemplateFullPath($name)
    {
        $app  = \Slim\Slim::getInstance();
        $lang = $app->lang;

        $templatesPath = $app->config('templates.path');
        $result        = realpath($templatesPath . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $name);

        return $result;
    }
}
