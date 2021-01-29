<?php

/**
 * @version SVN: $Id: PaymentController.php 113 2015-05-20 08:23:04Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Pager;
use NBPA\Services\PaymentService;
use NBPA\Services\MemberService;

class PaymentController
{
    const LIMIT = 100;

    /**
     * 課金一覧画面を表示する.
     *
     * GET /payment/index
     */
    public static function index($app)
    {
        unset($_SESSION['memberId']);
        unset($_SESSION['txNo']);
        unset($_SESSION['createdAt']);

        // Search keyword
        $q = $app->request->get('q');

        $page   = $app->request->get('page');
        $page   = isset($page) ? (int) $page : 0;
        $limit  = self::LIMIT;
        $offset = self::LIMIT * $page;
        $count  = 0;

        $clause     = '';
        $parameters = [];

        if (isset($q)) {
            $q = trim($q);
            if (strlen($q) > 0) {
                $clause .= 'ref_no = ? OR tx_no = ? OR p.member_regist_no = ?';
                $parameters[] = "{$q}";
                $parameters[] = "{$q}";
                $parameters[] = "{$q}";
            }
        }

        $payments = [];
        if (strlen($clause) > 0) {
            $payments = \ORM::forTable('t_payment')
                ->tableAlias('p')
                ->select('p.*')
                ->select('u.name_m')
                ->select('u.name_s')
                ->join('t_member_regist', ['p.member_regist_no', '=', 'u.member_regist_no'], 'u')
                ->whereRaw($clause, $parameters)
                ->offset($offset)
                ->limit($limit)
                ->orderByDesc('id')
                ->findMany();
            $count = \ORM::forTable('t_payment')
                ->tableAlias('p')
                ->whereRaw($clause, $parameters)
                ->count();
        } else {
            $payments = \ORM::forTable('t_payment')
                ->tableAlias('p')
                ->select('p.*')
                ->select('u.name_m')
                ->select('u.name_s')
                ->join('t_member_regist', ['p.member_regist_no', '=', 'u.member_regist_no'], 'u')
                ->offset($offset)
                ->limit($limit)
                ->orderByDesc('id')
                ->findMany();
            $count = \ORM::forTable('t_payment')
                ->count();
        }

        $app->render(
            'manager/payment/index.php',
            [
                'app'      => $app,
                'q'        => $q,
                'page'     => $page,
                'pager'    => new Pager("/manager/payment/index?q={$q}", $limit, $count, $page),
                'count'    => $count,
                'payments' => $payments,
            ]
        );
    }

    /**
     * 課金ステータスを更新する.
     */
    public static function chgStatus($app)
    {
        $page = $app->request->post('page');
        $q    = $app->request->post('q');

        $payIds = $app->request->post('payid');

        $toI = $app->request->post('toInvalid');
        $toV = $app->request->post('toValid');

        $resultCode = -1;
        if (isset($toI)) {
            $resultCode = 1;
        }
        if (isset($toV)) {
            $resultCode = 0;
        }

        if (count($payIds) > 0) {
            foreach ($payIds as $payId) {
                $payment = \ORM::forTable('t_payment')
                    ->where('id', $payId)
                    ->findOne();
                if ($payment) {
                    if ($resultCode == 0 || $resultCode == 1) {
                        $payment->result_code = $resultCode;
                        $payment->save();
                    }
                }
            }
        }

        $app->redirect('/manager/payment/index?q=' . $q . '&page=' . $page);
    }

    /**
     * 課金詳細画面を表示する.
     *
     * GET /payment/show/:id
     */
    public static function show($app, $id)
    {
        $q = $app->request->get('q');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $payment = PaymentService::getPayment($id);

        $app->render(
            'manager/payment/show.php',
            [
                'app'     => $app,
                'q'       => $q,
                'page'    => $page,
                'payment' => $payment,
            ]
        );
    }

    /**
     * 銀行振込画面を表示する.
     *
     * GET /payment/addBank
     */
    public static function addBank($app)
    {
        $q = $app->request->get('q');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $memberId  = isset($_SESSION['memberId']) ? $_SESSION['memberId'] : '';
        $txNo      = isset($_SESSION['txNo']) ? $_SESSION['txNo'] : '';
        $createdAt = isset($_SESSION['createdAt']) ? $_SESSION['createdAt'] : '';

        $app->render(
            'manager/payment/addbank.php',
            [
                'app'       => $app,
                'q'         => $q,
                'page'      => $page,
                'memberId'  => $memberId,
                'txNo'      => $txNo,
                'createdAt' => $createdAt,
            ]
        );
    }

    /**
     * 銀行振込確認画面を表示する.
     *
     * POST /payment/confirmBank
     */
    public static function confirmBank($app)
    {
        $q = $app->request->get('q');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $errors = [];

        // validation
        $memberId = $app->request->post('uid');
        $member   = MemberService::getMemberByMemberRegistNo($memberId);
        if ($member === false) {
            $errors[] = 'Member could not found. ID=' . $memberId;
        }
        $txNo = $app->request->post('tx_no');
        if (strlen($txNo) == 0) {
            $errors[] = 'Please enter a transaction number.';
        }
        $createdAt = $app->request->post('created_at');
        if (strlen($createdAt) == 0) {
            $errors[] = 'Please enter a transaction date.';
        }
        if (!strptime($createdAt, '%Y-%m-%d %H:%M:%S')) {
            $errors[] = 'Invalid transaction date format (YYYY-mm-dd HH:MM:ss).';
        }

        $_SESSION['memberId']  = $memberId;
        $_SESSION['txNo']      = $txNo;
        $_SESSION['createdAt'] = $createdAt;

        if (count($errors) > 0) {
            $app->flash('errors', $errors);
            $app->redirect('/manager/payment/addBank');
        } else {
            $app->render(
                'manager/payment/confirmbank.php',
                [
                    'app'       => $app,
                    'q'         => $q,
                    'page'      => $page,
                    'memberId'  => $memberId,
                    'member'    => $member,
                    'txNo'      => $txNo,
                    'createdAt' => $createdAt,
                ]
            );
        }
    }

    /**
     * 銀行振込を保存する.
     *
     * POST /payment/saveBank
     */
    public static function saveBank($app)
    {
        $memberId  = isset($_SESSION['memberId']) ? $_SESSION['memberId'] : '';
        $txNo      = isset($_SESSION['txNo']) ? $_SESSION['txNo'] : '';
        $createdAt = isset($_SESSION['createdAt']) ? $_SESSION['createdAt'] : '';

        $errors = [];

        // validation
        $member = MemberService::getMemberByMemberRegistNo($memberId);
        if ($member === false) {
            $errors[] = 'Member could not found. ID=' . $memberId;
        }
        if (strlen($txNo) == 0) {
            $errors[] = 'Please enter a transaction number.';
        }
        if (strlen($createdAt) == 0) {
            $errors[] = 'Please enter a transaction date.';
        }
        if (!strptime($createdAt, '%Y-%m-%d %H:%M:%S')) {
            $errors[] = 'Invalid transaction date format (YYYY-mm-dd HH:MM:ss).';
        }

        if (count($errors) > 0) {
            $app->flash('errors', $errors);
            $app->redirect('/manager/payment/addBank');
        } else {
            // save
            PaymentService::saveBank($memberId, $txNo, $createdAt);
            $app->redirect('/manager/payment/index');
        }
    }
}
