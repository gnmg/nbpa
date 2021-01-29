<?php

/**
 * @version SVN: $Id: MailService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

class MailService
{
    const MAIL_FROM = 'info@naturesbestphotography.asia';

    /**
     * メールを送信する.
     */
    public static function sendMail($rcptTo, $subject, $message)
    {
        $from    = self::MAIL_FROM;
        $replyTo = self::MAIL_FROM;

        $subject = '=?utf-8?B?' . base64_encode($subject) . '?=';

        $headers = <<<EOS
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
From: $from
Reply-To: $replyTo
EOS;
        $additional = '-f' . $from;

        mail($rcptTo, $subject, $message, $headers, $additional);
    }

    /**
     * パスワード忘れメールを送信する.
     */
    public static function sendForgotMail($rcptTo, $mid, $t)
    {
        $app = \Slim\Slim::getInstance();

        $filename = TemplateService::getTemplateFullPath('mail/forgot.txt');
        $app->log->debug($filename);

        $subject = '';
        $message = '';

        $lines = file($filename);
        if ($lines) {
            foreach ($lines as $line) {
                if (preg_match('/^Subject:\s+(.*)$/', $line, $matches)) {
                    $subject = $matches[1];
                } else {
                    $message .= $line;
                }
            }
        }

        $patterns = [
            '/__MAIL__/', '/__MID__/', '/__T__/',
        ];
        $replacements = [
            $rcptTo, rawurlencode($mid), $t,
        ];
        $message = preg_replace($patterns, $replacements, $message);
        $app->log->debug($message);

        self::sendMail($rcptTo, $subject, $message);
    }

    /**
     * 仮登録完了メールを送信する.
     */
    public static function sendPreRegisteringMail($name, $rcptTo, $mid, $t)
    {
        $app = \Slim\Slim::getInstance();

        $filename = TemplateService::getTemplateFullPath('mail/pre_registering.txt');
        $app->log->debug($filename);

        $subject = '';
        $message = '';

        $lines = file($filename);
        if ($lines) {
            foreach ($lines as $line) {
                if (preg_match('/^Subject:\s+(.*)$/', $line, $matches)) {
                    $subject = $matches[1];
                } else {
                    $message .= $line;
                }
            }
        }

        $patterns = [
            '/__NAME__/', '/__MID__/', '/__T__/',
        ];
        $replacements = [
            $name, rawurlencode($mid), $t,
        ];
        $message = preg_replace($patterns, $replacements, $message);
        $app->log->debug($message);

        self::sendMail($rcptTo, $subject, $message);
    }

    /**
     * 登録完了メールを送信する.
     */
    public static function sendRegisteringMail($name, $rcptTo)
    {
        $app = \Slim\Slim::getInstance();

        $filename = TemplateService::getTemplateFullPath('mail/registering.txt');
        $app->log->debug($filename);

        $subject = '';
        $message = '';

        $lines = file($filename);
        if ($lines) {
            foreach ($lines as $line) {
                if (preg_match('/^Subject:\s+(.*)$/', $line, $matches)) {
                    $subject = $matches[1];
                } else {
                    $message .= $line;
                }
            }
        }

        $patterns = [
            '/__NAME__/', '/__MAIL__/',
        ];
        $replacements = [
            $name, $rcptTo,
        ];
        $message = preg_replace($patterns, $replacements, $message);
        $app->log->debug($message);

        self::sendMail($rcptTo, $subject, $message);
    }
}
