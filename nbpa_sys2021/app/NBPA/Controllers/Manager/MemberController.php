<?php

/**
 * @version SVN: $Id: MemberController.php 125 2015-06-04 15:01:24Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Country;
use NBPA\Models\Pager;
use NBPA\Services\MemberService;
use NBPA\Services\EntryService;
use NBPA\Services\ValidationService as vs;

class MemberController
{
    const LIMIT = 100;

    /**
     * 会員一覧画面を表示する.
     *
     * GET /member/index
     */
    public static function index($app)
    {
        // keyword
        $q = $app->request->get('q');
        // country
        $c = $app->request->get('c');

        $page   = $app->request->get('page');
        $page   = isset($page) ? (int) $page : 0;
        $limit  = self::LIMIT;
        $offset = self::LIMIT * $page;
        $count  = 0;

        $action = $app->request->get('action');

        $clause     = '';
        $parameters = [];

        if (isset($q)) {
            $q = trim($q);
            if (strlen($q) > 0) {
                $clause .= 'name_s LIKE ? OR name_m LIKE ? OR mail LIKE ?';
                $parameters[] = "%{$q}%";
                $parameters[] = "%{$q}%";
                $parameters[] = "%{$q}%";
            }
        }

        if ($c > 0) {
            if (strlen($clause) > 0) {
                $clause .= ' AND pref = ?';
                $parameters[] = "{$c}";
            } else {
                $clause .= 'pref = ?';
                $parameters[] = "{$c}";
            }
        }

        $members = [];
        if ($action == 'csv') {
            if (strlen($clause) > 0) {
                $members = \ORM::forTable('t_member_regist')
                    ->whereRaw($clause, $parameters)
                    ->orderByAsc('member_regist_no')
                    ->findMany();
            } else {
                $members = \ORM::forTable('t_member_regist')
                    ->orderByAsc('member_regist_no')
                    ->findMany();
            }
        } else {
            if (strlen($clause) > 0) {
                $members = \ORM::forTable('t_member_regist')
                    ->whereRaw($clause, $parameters)
                    ->offset($offset)
                    ->limit($limit)
                    ->orderByDesc('member_regist_no')
                    ->findMany();
                $count = \ORM::forTable('t_member_regist')
                    ->whereRaw($clause, $parameters)
                    ->count();
            } else {
                $members = \ORM::forTable('t_member_regist')
                    ->offset($offset)
                    ->limit($limit)
                    ->orderByDesc('member_regist_no')
                    ->findMany();
                $count = \ORM::forTable('t_member_regist')
                    ->count();
            }
        }

        if ($action == 'csv') {
            $app->response->headers->set('Content-Type', 'application/octet-stream');
            $app->response->headers->set('Content-Disposition', 'attachment; filename="data-members.csv"');

            $stream = tmpfile();
            fwrite($stream, pack('C*', 0xEF, 0xBB, 0xBF)); // BOM

            $header = [
                'member_id',
                'first_name',
                'last_name',
                'mail',
                'postal_code',
                'country',
                'address',
                'tel',
                'mobile',
                'gender',
                'promotion_code',
                'registered_at',
            ];
            fputcsv($stream, $header);

            foreach ($members as $member) {
                $fields   = [];
                $fields[] = $member->member_regist_no;
                $fields[] = $member->name_m;
                $fields[] = $member->name_s;
                $fields[] = $member->mail;
                $fields[] = $member->zipcode1;
                $fields[] = Country::$countries[$member->pref];
                $fields[] = $member->apname;
                $fields[] = $member->tel;
                $fields[] = $member->mb_tel;
                $fields[] = $member->sex;
                $fields[] = $member->promotion_code;
                $fields[] = $member->entry_date;
                fputcsv($stream, $fields);
            }
            rewind($stream);
            while (($data = fgets($stream, 4096)) !== false) {
                $app->response->write($data);
            }
            fclose($stream);
        } else {
            $app->render(
                'manager/member/index.php',
                [
                    'app'       => $app,
                    'q'         => $q,
                    'c'         => $c,
                    'countries' => Country::$countries,
                    'page'      => $page,
                    'pager'     => new Pager("/manager/member/index?q={$q}&c={$c}", $limit, $count, $page),
                    'count'     => $count,
                    'members'   => $members,
                ]
            );
        }
    }

    /**
     * 会員詳細画面を表示する.
     *
     * GET /member/show/:id
     */
    public static function show($app, $id)
    {
        // keyword
        $q = $app->request->get('q');
        // country
        $c = $app->request->get('c');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $member = MemberService::getMemberByMemberRegistNo($id);

        $app->render(
            'manager/member/show.php',
            [
                'app'       => $app,
                'q'         => $q,
                'c'         => $c,
                'countries' => Country::$countries,
                'page'      => $page,
                'member'    => $member,
            ]
        );
    }

    /**
     * 会員編集画面を表示する.
     *
     * GET /member/edit/:id
     */
    public static function edit($app, $id)
    {
        // keyword
        $q = $app->request->get('q');
        // country
        $c = $app->request->get('c');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $member = MemberService::getMemberByMemberRegistNo($id);

        $app->render(
            'manager/member/edit.php',
            [
                'app'       => $app,
                'q'         => $q,
                'c'         => $c,
                'countries' => Country::$countries,
                'page'      => $page,
                'member'    => $member,
            ]
        );
    }

    /**
     * 会員情報を更新する.
     *
     * POST /member/edit
     */
    public static function save($app)
    {
        $id   = $app->request->post('id');
        $q    = $app->request->post('q');
        $c    = $app->request->post('c');
        $page = $app->request->post('page');

        $member = MemberService::getMemberByMemberRegistNo($id);

        $action = $app->request->post('action');
        $app->log->debug('action=' . $action);
        if ($action == 'save') {
            $mail         = $app->request->post('mail');
            $completeFlag = $app->request->post('complete_flag');
            $firstName    = $app->request->post('name_m');
            $lastName     = $app->request->post('name_s');
            $address      = $app->request->post('apname');
            $country      = $app->request->post('pref');
            $zipcode      = $app->request->post('zipcode1');
            $tel          = $app->request->post('tel');
            $mobile       = $app->request->post('mb_tel');
            $gender       = $app->request->post('sex');

            // validation
            $errors = [];
            // mail
            if ($error = vs::validateEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // first name
            if ($error = vs::validateFirstName($firstName)) {
                $errors = array_merge($errors, $error);
            }
            // last name
            if ($error = vs::validateLastName($lastName)) {
                $errors = array_merge($errors, $error);
            }
            // zipcode
            if ($error = vs::validatePostalCode($zipcode)) {
                $errors = array_merge($errors, $error);
            }
            // country
            if ($error = vs::validateCountry($country)) {
                $errors = array_merge($errors, $error);
            }
            // address
            if ($error = vs::validateAddress($address)) {
                $errors = array_merge($errors, $error);
            }
            // tel
            if ($error = vs::validateTelephone($tel)) {
                $errors = array_merge($errors, $error);
            }
            // mobile
            if ($error = vs::validateMobile($mobile)) {
                $errors = array_merge($errors, $error);
            }

            $member->mail          = $mail;
            $member->complete_flag = $completeFlag;
            $member->name_m        = $firstName;
            $member->name_s        = $lastName;
            $member->apname        = $address;
            $member->pref          = $country;
            $member->zipcode1      = $zipcode;
            $member->tel           = $tel;
            $member->mb_tel        = $mobile;
            $member->sex           = $gender;

            if (!empty($errors)) {
                $app->flashNow('errors', $errors);
                $app->render(
                    'manager/member/edit.php',
                    [
                        'app'       => $app,
                        'q'         => $q,
                        'c'         => $c,
                        'countries' => Country::$countries,
                        'page'      => $page,
                        'member'    => $member,
                    ]
                );
            } else {
                // save
                $member->use_id_column('member_regist_no');
                $member->save();

                $app->flash('message', 'Storing member data has completed.');
                $app->redirect("/manager/member/show/{$id}?q={$q}&c={$c}&page={$page}");
            }
        } elseif ($action == 'delete') {
            $db = \ORM::getDb();

            try {
                $db->beginTransaction();

                $memberRegistNo = $id;

                // delete entries
                $entries = EntryService::getEntriesByMemberRegistNo($memberRegistNo);
                if ($entries) {
                    foreach ($entries as $entry) {
                        $registApplyNo = $entry->regist_apply_no;
                        $entry->use_id_column('regist_apply_no');
                        $entry->delete();

                        $points = \ORM::forTable('t_apply_points')
                            ->where('regist_apply_no', $registApplyNo)
                            ->findMany();
                        if ($points) {
                            foreach ($points as $point) {
                                $point->delete();
                            }
                        }
                    }
                }

                // delete member
                $member->use_id_column('member_regist_no');
                $member->delete();

                $db->commit();
                $app->flash('message', 'Success to delete a member data.');
            } catch (Exception $e) {
                $app->flash('errors', 'Failed to delete a member data.');
                $db->rollBack();
            }
            $app->redirect("/manager/member/index?q={$q}&c={$c}&page={$page}");
        }
    }
}
