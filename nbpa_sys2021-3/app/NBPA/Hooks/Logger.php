<?php

/**
 * Initialize a logger.
 *
 * @version SVN: $Id: Logger.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Hooks;

class Logger
{
    public static function execute()
    {
        $app = \Slim\Slim::getInstance();

        $logConfig = $app->config('log.web');

        $app->log->setWriter(new \Slim\Logger\DateTimeFileWriter($logConfig));
    }
}
