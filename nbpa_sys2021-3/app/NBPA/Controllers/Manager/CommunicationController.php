<?php

/**
 * @version SVN: $Id: CommunicationController.php 114 2015-06-02 11:40:00Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Country;

class CommunicationController
{
    /**
     * メール抽出画面を表示する.
     *
     * GET /communication/index
     */
    public static function index($app)
    {
        $app->render(
            'manager/communication/index.php',
            [
                'app' => $app,
            ]
        );
    }

    public static function pick($app)
    {
        $kind = $app->request->post('kind');
        $year = $app->request->post('year');

        $action = $app->request->post('action');

        $members = [];

        if ($kind == 1) { // Registered
            $orm = \ORM::forTable('t_member_regist')
                ->orderByAsc('member_regist_no');
            if ($year > 0) {
                $orm->whereRaw('YEAR(entry_date) = ?', [$year]);
            }
            $members = $orm->findMany();
        } elseif ($kind == 2) { // Entried
            if ($year > 0) {
                $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE YEAR(entry_date) = ?) ORDER BY member_regist_no
EOS;
                $members = \ORM::forTable('t_member_regist')
                    ->rawQuery($sql, [$year])
                    ->findMany();
            } else {
                $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply) ORDER BY member_regist_no
EOS;
                $members = \ORM::forTable('t_member_regist')
                    ->rawQuery($sql)
                    ->findMany();
            }
        } elseif ($kind == 3) { // Not entried
            if ($year > 0) {
                $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no NOT IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE YEAR(entry_date) = ?) ORDER BY member_regist_no
EOS;
                $members = \ORM::forTable('t_member_regist')
                    ->rawQuery($sql, [$year])
                    ->findMany();
            } else {
                $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no NOT IN (SELECT DISTINCT member_regist_no FROM t_regist_apply) ORDER BY member_regist_no
EOS;
                $members = \ORM::forTable('t_member_regist')
                    ->rawQuery($sql)
                    ->findMany();
            }
        } elseif (
            $kind == 4 || // 1st approved
            $kind == 5 || // 2nd approved
            $kind == 6 || // Semi final approved
            $kind == 7    // Winner
        ) {
            if ($kind == 4) {
                $judgeStatus = 2;
            }
            if ($kind == 5) {
                $judgeStatus = 4;
            }
            if ($kind == 6) {
                $judgeStatus = 6;
            }
            if ($kind == 7) {
                $judgeStatus = 6;
            }
            if ($year > 0) {
                if ($kind == 4 || $kind == 5 | $kind == 6) {
                    $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE YEAR(entry_date) = ? AND judge_status = ?) ORDER BY member_regist_no
EOS;
                    $members = \ORM::forTable('t_member_regist')
                        ->rawQuery($sql, [$year, $judgeStatus])
                        ->findMany();
                } elseif ($kind == 7) {
                    $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE YEAR(entry_date) = ? AND judge_status > ?) ORDER BY member_regist_no
EOS;
                    $members = \ORM::forTable('t_member_regist')
                        ->rawQuery($sql, [$year, $judgeStatus])
                        ->findMany();
                }
            } else {
                if ($kind == 4 || $kind == 5 | $kind == 6) {
                    $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE judge_status = ?) ORDER BY member_regist_no
EOS;
                    $members = \ORM::forTable('t_member_regist')
                        ->rawQuery($sql, [$judgeStatus])
                        ->findMany();
                } elseif ($kind == 7) {
                    $sql = <<<EOS
SELECT * FROM t_member_regist WHERE member_regist_no IN (SELECT DISTINCT member_regist_no FROM t_regist_apply WHERE judge_status > ?) ORDER BY member_regist_no
EOS;
                    $members = \ORM::forTable('t_member_regist')
                        ->rawQuery($sql, [$judgeStatus])
                        ->findMany();
                }
            }
        }

        if ($action == 'csv') {
            $app->response->headers->set('Content-Type', 'application/octet-stream');
            $app->response->headers->set('Content-Disposition', 'attachment; filename="mail-members.csv"');

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
                $fields[] = $member->entry_date;
                fputcsv($stream, $fields);
            }
            rewind($stream);
            while (($data = fgets($stream, 4096)) !== false) {
                $app->response->write($data);
            }
            fclose($stream);
        }
    }
}
