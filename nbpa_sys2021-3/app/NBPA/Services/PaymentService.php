<?php

/**
 * @version SVN: $Id: PaymentService.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Services;

use NBPA\Models\Datafeed;
use NBPA\Models\Payment;
use NBPA\Models\PayPal;
use NBPA\Models\GmoPg;

class PaymentService
{
    // 参照番号のデリミタ文字
    const SEP = '.';

    /**
     * クレジットカード決済のための参照文字列を生成する.
     */
    public static function getRefNumber($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return;
        }
        $result = uniqid($memberRegistNo . self::SEP, true);

        if (strlen($result) > 27) {
            $result = substr($result, 0, 27);
        }

        return $result;
    }

    /**
     * 参照文字列から memberRegistNo を抽出する.
     */
    public static function getMemberRegistNoFromRefNumber($refNumber)
    {
        $pos = strpos($refNumber, self::SEP);
        if ($pos !== false) {
            $result = substr($refNumber, 0, $pos);
        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * 新規に PayDollar の Datafeed を登録する.
     */
    public static function newDatafeed(
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
    ) {
        $app = \Slim\Slim::getInstance();

        $result = false;

        $db = \ORM::getDb();

        try {
            $db->beginTransaction();

            // datafeed
            $datafeed = Datafeed::createDatafeed();

            $datafeed->member_regist_no        = $memberRegistNo;
            $datafeed->pd_prc                  = $prc;
            $datafeed->pd_src                  = $src;
            $datafeed->pd_ord                  = $ord;
            $datafeed->pd_ref                  = $ref;
            $datafeed->pd_payref               = $payRef;
            $datafeed->pd_successcode          = $successcode;
            $datafeed->pd_amt                  = $amt;
            $datafeed->pd_cur                  = $cur;
            $datafeed->pd_holder               = $holder;
            $datafeed->pd_auth_id              = $authId;
            $datafeed->pd_alert_code           = $alertCode;
            $datafeed->pd_remark               = $remark;
            $datafeed->pd_eci                  = $eci;
            $datafeed->pd_payer_auth           = $payerAuth;
            $datafeed->pd_source_ip            = $sourceIp;
            $datafeed->pd_ip_country           = $ipCountry;
            $datafeed->pd_pay_method           = $payMethod;
            $datafeed->pd_tx_time              = $txTime;
            $datafeed->pd_pan_first4           = $panFirst4;
            $datafeed->pd_pan_last4            = $panLast4;
            $datafeed->pd_card_issuing_country = $cardIssuingCountry;
            $datafeed->pd_channel_type         = $channelType;
            $datafeed->pd_merchant_id          = $merchantId;
            $datafeed->created_at              = date('Y-m-d H:i:s');

            $result = $datafeed->save();

            // payment
            $payment = Payment::createPayment();

            $payment->member_regist_no = $memberRegistNo;
            $payment->ref_no           = $ref;
            $payment->tx_no            = $payRef;
            $payment->kind             = Payment::KIND_PAYDOLLAR;
            $payment->result_code      = $successcode;
            $payment->created_at       = date('Y-m-d H:i:s');

            $result = $result && $payment->save();

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            $app->log->error($e->getMessage());
        }

        return $result;
    }

    /**
     * 新規に PayPal の IPN を登録する.
     */
    public static function newIPN($memberRegistNo, $paymentStatus, $invoice, $txnId, $amount, $IPN)
    {
        $app = \Slim\Slim::getInstance();

        $result = false;

        $db = \ORM::getDb();

        try {
            $db->beginTransaction();

            // PayPal IPN
            $paypal = PayPal::createIPN();

            $paypal->member_regist_no = $memberRegistNo;
            $paypal->payment_status   = $paymentStatus;
            $paypal->invoice          = $invoice;
            $paypal->ipn              = $IPN;
            $paypal->created_at       = date('Y-m-d H:i:s');

            $result = $paypal->save();

            $successcode = ($paymentStatus == 'Completed') ? 0 : 1;

            // payment
            $payment = Payment::createPayment();

            $payment->member_regist_no = $memberRegistNo;
            $payment->ref_no           = $invoice;
            $payment->tx_no            = $txnId;
            $payment->kind             = Payment::KIND_PAYPAL;
            $payment->result_code      = $successcode;
            $payment->amount           = $amount;
            $payment->created_at       = date('Y-m-d H:i:s');

            $result = $result && $payment->save();

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            $app->log->error($e->getMessage());
        }

        return $result;
    }

    /**
     * 新規に GMO PG の結果を登録する.
     */
    public static function newGmoPg($memberRegistNo, $invoice, $txnId, $errInfo, $accessId, $amount, $rawPostData)
    {
        $app = \Slim\Slim::getInstance();

        $result = false;

        $db = \ORM::getDb();

        try {
            $db->beginTransaction();

            // GMO PG result
            $gmopg = GmoPg::createResult();

            $gmopg->member_regist_no = $memberRegistNo;
            $gmopg->errinfo          = $errInfo;
            $gmopg->invoice          = $invoice;
            $gmopg->results          = $rawPostData;
            $gmopg->created_at       = date('Y-m-d H:i:s');

            $result = $gmopg->save();

            $successcode = 1;
            if (empty($errInfo) && !empty($accessId)) {
                $successcode = 0;
            }

            // payment
            $payment = Payment::createPayment();

            $payment->member_regist_no = $memberRegistNo;
            $payment->ref_no           = $invoice;
            $payment->tx_no            = $txnId;
            $payment->kind             = Payment::KIND_GMOPG_MCP;
            $payment->result_code      = $successcode;
            $payment->amount           = $amount;
            $payment->created_at       = date('Y-m-d H:i:s');

            $result = $result && $payment->save();

            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            $app->log->error($e->getMessage());
        }

        return $result;
    }

    /**
     * 購入済みの提出枠数を取得する.
     */
    public static function getPicturePurchased($memberRegistNo)
    {
        if (empty($memberRegistNo)) {
            return 0;
        }
        $result = 0;

        $app = \Slim\Slim::getInstance();

        $picturePackage = $app->config('picture.package');
        $purchasedCount = Payment::getPurchasedCount($memberRegistNo);

        $result = $picturePackage * $purchasedCount;

        return $result;
    }

    /**
     * 課金情報を取得する.
     */
    public static function getPayment($id)
    {
        $payment = null;

        $payment = \ORM::forTable('t_payment')
            ->where('id', $id)
            ->findOne();
        if ($payment) {
            if ($payment->kind == Payment::KIND_PAYDOLLAR) {
                $detail = \ORM::forTable('t_paydollar_datafeed')
                    ->where('pd_ref', $payment->ref_no)
                    ->findOne();
                if ($detail) {
                    $payment->detail = [
                        'prc'                => $detail->pd_prc,
                        'src'                => $detail->pd_src,
                        'Ord'                => $detail->pd_ord,
                        'Ref'                => $detail->pd_ref,
                        'PayRef'             => $detail->pd_payref,
                        'successcode'        => $detail->pd_successcode,
                        'Amt'                => $detail->pd_amt,
                        'Cur'                => $detail->pd_cur,
                        'Holder'             => $detail->pd_holder,
                        'AuthId'             => $detail->pd_auth_id,
                        'AlertCode'          => $detail->pd_alert_code,
                        'remark'             => $detail->pd_remark,
                        'eci'                => $detail->pd_eci,
                        'payerAuth'          => $detail->pd_payer_auth,
                        'sourceIp'           => $detail->pd_source_ip,
                        'ipCountry'          => $detail->pd_ip_country,
                        'payMethod'          => $detail->pd_pay_method,
                        'TxTime'             => $detail->pd_tx_time,
                        'panFirst4'          => $detail->pd_pan_first4,
                        'panLast4'           => $detail->pd_pan_last4,
                        'cardIssuingCountry' => $detail->pd_card_issuing_country,
                        'channelType'        => $detail->pd_channel_type,
                        'MerchantId'         => $detail->pd_merchant_id,
                    ];
                }
            } elseif ($payment->kind == Payment::KIND_PAYPAL) {
                $detail = \ORM::forTable('t_paypal_ipn')
                    ->where('invoice', $payment->ref_no)
                    ->findOne();
                if ($detail) {
                    $ipn = $detail->ipn;
                    parse_str($ipn, $ipnArray);
                    $payment->detail = $ipnArray;
                }
            } elseif ($payment->kind == Payment::KIND_GMOPG_MCP) {
                $detail = \ORM::forTable('t_gmopg_result')
                    ->where('invoice', $payment->ref_no)
                    ->findOne();
                if ($detail) {
                    $results = $detail->results;
                    parse_str($results, $resultArray);
                    $payment->detail = $resultArray;
                }
            }
        }

        return $payment;
    }

    /**
     * 銀行振込情報を保存する.
     */
    public static function saveBank($memberId, $txNo, $createdAt)
    {
        $payment = \ORM::forTable('t_payment')->create();

        $payment->member_regist_no = $memberId;
        $payment->ref_no           = $txNo;
        $payment->tx_no            = $txNo;
        $payment->kind             = Payment::KIND_BANK_TRANSFER;
        $payment->result_code      = 0;
        $payment->created_at       = $createdAt;

        $payment->save();
    }
}