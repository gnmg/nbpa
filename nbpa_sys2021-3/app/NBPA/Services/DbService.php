<?php

/**
 * Initialize IDIORM.
 *
 * @version SVN: $Id: DbService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

class DbService
{
    /**
     * Initialize.
     */
    public static function configure()
    {
        $app = \Slim\Slim::getInstance();

        $connection = $app->config('db.connection');

        \ORM::configure($connection);
    }
}
