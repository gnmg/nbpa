<?php

/**
 * @version SVN: $Id: PaymentController.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Controllers;

use NBPA\Services\TemplateService;
use NBPA\Services\PaymentService;

class PaymentController
{
    /**
     * 決済成功画面を表示する.
     *
     * GET /payment/success
     */
    public static function success($app)
    {
        $app->render(
            TemplateService::getTemplatePath('payment/success.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * 決済失敗画面を表示する.
     *
     * GET /payment/fail
     */
    public static function fail($app)
    {
        $errInfo = $app->request->get('errInfo');
        $app->render(
            TemplateService::getTemplatePath('payment/fail.php'),
            [
                'app'     => $app,
                'errInfo' => $errInfo,
            ]
        );
    }

    /**
     * 決済キャンセル画面を表示する.
     *
     * GET /payment/cancel
     */
    public static function cancel($app)
    {
        $app->render(
            TemplateService::getTemplatePath('payment/cancel.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * PayDollar データフィードを受信する.
     *
     * POST /payment/datafeed
     */
    public static function datafeed($app)
    {
        // 応答ヘッダとボディをそのままログに記録する。
        $app->log->debug(print_r($app->request->headers, true));
        $app->log->debug(print_r($app->request->getBody(), true));

        echo 'OK';          // response 'OK' immediately.

        $prc                = $app->request->post('prc');
        $src                = $app->request->post('src');
        $ord                = $app->request->post('Ord');
        $ref                = $app->request->post('Ref');
        $payRef             = $app->request->post('PayRef');
        $successcode        = $app->request->post('successcode');
        $amt                = $app->request->post('Amt');
        $cur                = $app->request->post('Cur');
        $holder             = $app->request->post('Holder');
        $authId             = $app->request->post('AuthId');
        $alertCode          = $app->request->post('AlertCode');
        $remark             = $app->request->post('remark');
        $eci                = $app->request->post('eci');
        $payerAuth          = $app->request->post('payerAuth');
        $sourceIp           = $app->request->post('sourceIp');
        $ipCountry          = $app->request->post('ipCountry');
        $payMethod          = $app->request->post('payMethod');
        $txTime             = $app->request->post('TxTime');
        $panFirst4          = $app->request->post('panFirst4');
        $panLast4           = $app->request->post('panLast4');
        $cardIssuingCountry = $app->request->post('cardIssuingCountry');
        $channelType        = $app->request->post('channelType');
        $merchantId         = $app->request->post('MerchantId');

        $memberRegistNo = PaymentService::getMemberRegistNoFromRefNumber($ref);

        PaymentService::newDatafeed(
            $memberRegistNo,
            $prc,
            $src,
            $ord,
            $ref,
            $payRef,
            $successcode,
            $amt,
            $cur,
            $holder,
            $authId,
            $alertCode,
            $remark,
            $eci,
            $payerAuth,
            $sourceIp,
            $ipCountry,
            $payMethod,
            $txTime,
            $panFirst4,
            $panLast4,
            $cardIssuingCountry,
            $channelType,
            $merchantId
        );
    }

    /**
     * PayPal IPN を受信する.
     *
     * POST /payment/paypalIPN
     */
    public static function paypalIPN($app)
    {
        // 応答ヘッダとボディをそのままログに記録する。
        $app->log->debug(print_r($app->request->headers, true));
        $app->log->debug(print_r($app->request->getBody(), true));

        $rawPostData  = $app->request->getBody();
        $rawPostArray = explode('&', $rawPostData);
        $myData       = [];
        foreach ($rawPostArray as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myData[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        $req = 'cmd=_notify-validate';
        foreach ($myData as $key => $value) {
            $value = urlencode($value);
            $req .= "&{$key}={$value}";
        }

        $invoice       = $app->request->post('invoice');
        $txnId         = $app->request->post('txn_id');
        $paymentStatus = $app->request->post('payment_status');

        $memberRegistNo = PaymentService::getMemberRegistNoFromRefNumber($invoice);

        $amount = $app->request->post('payment_gross');

        PaymentService::newIPN(
            $memberRegistNo,
            $paymentStatus,
            $invoice,
            $txnId,
            $amount,
            $rawPostData
        );

        if ($app->config('paypal.sandbox')) {
            $paypalUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        } else {
            $paypalUrl = 'https://www.paypal.com/cgi-bin/webscr';
        }

        $res = '';

        $ch = curl_init($paypalUrl);
        if ($ch == false) {
            return;
        }
        if ($ch) {
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Connection: Close']);

            $res = curl_exec($ch);
            if (curl_errno($ch)) {
                curl_close($ch);

                return;
            } else {
                curl_close($ch);
            }
            $app->log->debug(print_r($res, true));
        }

        $tokens = explode("\r\n\r\n", trim($res));
        $res    = trim(end($tokens));
        $app->log->debug($res);
    }

    /**
     * GMO PG の Result を受信する.
     */
    public static function gmoPgResult($app)
    {
        // 応答ヘッダとボディをそのままログに記録する。
        $app->log->debug(print_r($app->request->headers, true));
        $app->log->debug(print_r($app->request->getBody(), true));

        $rawPostData  = $app->request->getBody();
        $rawPostArray = explode('&', $rawPostData);
        $myData       = [];
        foreach ($rawPostArray as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myData[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        $invoice = $app->request->post('ClientField1');
        $txnId   = $app->request->post('AccessID');
        $errInfo = $app->request->post('ErrInfo');

        $memberRegistNo = PaymentService::getMemberRegistNoFromRefNumber($invoice);

        $approve = $app->request->post('Approve');

        $checkString = $app->request->post('CheckString');
        $payType     = $app->request->post('PayType');

        $orderId  = $app->request->post('OrderID');
        $accessId = $app->request->post('AccessID');
        $tranDate = $app->request->post('TranDate');
        $amount   = $app->request->post('Amount');

        $gmoPassword = $app->settings['gmopg.password'];

        PaymentService::newGmoPg(
            $memberRegistNo,
            $invoice,
            $txnId,
            $errInfo,
            $accessId,
            $amount,
            $rawPostData
        );

        $verified = false;

        // 応答改ざんチェック
        if (!empty($checkString)) {
            if (!empty($payType)) {
                if ($payType == 'J') {
                    $target = $orderId . $accessId . $tranDate . $gmoPassword;
                    $check  = md5($target);
                    if ($check === $checkString) {
                        $verified = true;
                    }
                }
            }
        }

        if (!$verified || !empty($errInfo) || empty($accessId)) {
            $errRedirectUrl = '/user/payment/fail';
            $errRedirectUrl .= '?errInfo=' . $errInfo;
            $app->redirect($errRedirectUrl);
        } else {
            $successRedirectUrl = '/user/payment/success';
            $app->redirect($successRedirectUrl);
        }
    }
}
