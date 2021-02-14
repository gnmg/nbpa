<?php

/**
 * Settings.
 *
 * @version SVN: $Id: settings.php 150 2015-06-29 03:48:25Z morita $
 */

//
// development environment
//
$app->configureMode(
    'development',
    function () use ($app) {
        $app->config(
            [
                'log.web' => [
                    'path'           => '/tmp',
                    'name_format'    => 'Y-m-d',
                    'extension'      => 'txt',
                    'message_format' => '%label% - %date% - %message%',
                ],
                'log.level'      => \Slim\Log::DEBUG,
                'debug'          => true,
                'ssl'            => false,
                'templates.path' => APP_ROOT . '/app/NBPA/Templates',
                'db.connection'  => [
                    'username'          => '_dev_nbpadb',
                    'password'          => 'devnbpa',
                    'connection_string' => 'mysql:host=localhost;dbname=_nbpadb2016;charset=utf8',
                ],
                'images.path'          => '/tmp/images',
                'thumbnails.path'      => '/tmp/thumbnails',
                'hrimages.path'        => '/tmp/hrimages',
                'rawfiles.path'        => '/tmp/rawfiles',
                'payment.endpoint'     => 'https://test.paydollar.com/b2cDemo/eng/payment/payForm.jsp',
                'payment.merchant.id'  => '88121102',
                'payment.currency'     => '344',
                'payment.amount'       => '25.0',
                'payment.amount.youth' => '15.0',
                'payment.success.url'  => 'http://nbpa-dev.localhost/user/payment/success',
                'payment.fail.url'     => 'http://nbpa-dev.localhost/user/payment/fail',
                'payment.cancel.url'   => 'http://nbpa-dev.localhost/user/payment/cancel',
                'picture.package'      => 20,
                'paypal.sandbox'       => true,
                'tester.paydollar'     => [
                    'test1@nbpj.org',
                    'test2@nbpj.org',
                ],
                'gmopg.shopid'     => 'tshop00036256',
                'gmopg.password'   => '4m4h5dam',
                'gmopg.entry.url'  => 'https://pt01.mul-pay.jp/link/tshop00036256/Multi/Entry',
                'gmopg.result.url' => 'https://naturesbestphotography.asia/user/gmopg/result',
                'use.paydollar'    => false,
                'use.paypal'       => true,
                'use.gmopg'        => false,
                'usdjpy'           => 109.14,
                'rate.date'        => '2020/1/19',
            ]
        );
    }
);

//
// production environment
//
$app->configureMode(
    'production',
    function () use ($app) {
        $app->config(
            [
                'log.web' => [
                    'path'           => APP_ROOT . '/logs',
                    'name_format'    => 'Y-m-d',
                    'extension'      => 'txt',
                    'message_format' => '%label% - %date% - %message%',
                ],
                'log.level'      => \Slim\Log::DEBUG,
                'debug'          => false,
                'ssl'            => true,
                'templates.path' => APP_ROOT . '/app/NBPA/Templates',
                'db.connection'  => [
                    'username'          => 'naturesb_nbpa',
                    'password'          => 'i@~,x4;6EXov',
                    'connection_string' => 'mysql:host=localhost;dbname=naturesb_nbpa2020;charset=utf8',
                ],
                'images.path'          => APP_ROOT . '/images',
                'thumbnails.path'      => APP_ROOT . '/thumbnails',
                'hrimages.path'        => APP_ROOT . '/hrimages',
                'rawfiles.path'        => APP_ROOT . '/rawfiles',
                'payment.endpoint'     => 'https://www.paydollar.com/b2c2/eng/payment/payForm.jsp',
                'payment.merchant.id'  => '88592821',
                'payment.currency'     => '840',
                'payment.amount'       => '25.0',
                'payment.amount.youth' => '15.0',
                'payment.success.url'  => 'https://naturesbestphotography.asia/user/payment/success',
                'payment.fail.url'     => 'https://naturesbestphotography.asia/user/payment/fail',
                'payment.cancel.url'   => 'https://naturesbestphotography.asia/user/payment/cancel',
                'picture.package'      => 20,
                'paypal.sandbox'       => false,
                'tester.paydollar'     => [
                    'test1@nbpj.org',
                    'test2@nbpj.org',
                ],
                'gmopg.shopid'     => '9102471093574',
                'gmopg.password'   => '6tm9acrn',
                'gmopg.entry.url'  => 'https://p01.mul-pay.jp/link/9102471093574/Multi/Entry',
                'gmopg.result.url' => 'https://naturesbestphotography.asia/user/gmopg/result',
                'use.paydollar'    => false,
                'use.paypal'       => true,
                'use.gmopg'        => false,
                'usdjpy'           => 119.14,
                'rate.date'        => '2020/1/19',
            ]
        );
    }
);


