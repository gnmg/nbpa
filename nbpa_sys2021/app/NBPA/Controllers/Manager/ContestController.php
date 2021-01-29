<?php

/**
 * @version SVN: $Id: ContestController.php 161 2015-09-02 07:02:37Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Pager;
use NBPA\Models\Category;
use NBPA\Models\Contest;
use NBPA\Models\ApplyPoint;
use NBPA\Services\EntryService;
use NBPA\Services\MemberService;
use NBPA\Services\ValidationService as vs;

class ContestController
{
    const LIMIT = 100;

    /**
     * 画像を表示する.
     *
     * GET /entry/image/:uid/:id
     */
    public static function image($app, $uid, $id)
    {
        $imgDir = $app->config('images.path');

        $entry = EntryService::getEntry($uid, $id);
        if ($entry) {
            $category = $entry->apply_genre;
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->apply_image;
            if (file_exists($filename)) {
                $app->response->headers->set('Content-Type', 'image/jpeg');
                readfile($filename);
            }
        }
    }

    /**
     * サムネイル画像を表示する.
     *
     * GET /entry/thumbnail/:uid/:id
     */
    public static function thumbnail($app, $uid, $id)
    {
        $imgDir = $app->config('thumbnails.path');

        $entry = EntryService::getEntry($uid, $id);
        if ($entry) {
            $category = $entry->apply_genre;
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->apply_image;
            if (file_exists($filename)) {
                $app->response->headers->set('Content-Type', 'image/jpeg');
                readfile($filename);
            }
        }
    }

    /**
     * 応募一覧画面を表示する.
     *
     * GET /entry/index
     */
    public static function index($app)
    {
        $category = $app->request->get('c');
        $category = isset($category) ? (int) $category : 0;

        $stage = $app->request->get('s');
        $stage = isset($stage) ? (int) $stage : Contest::STAGE_1ST_POINT;

        $page    = $app->request->get('page');
        $page    = isset($page) ? (int) $page : 0;
        $limit   = self::LIMIT;
        $offset  = self::LIMIT * $page;
        $count   = 0;
        $entries = [];

        $judges = \ORM::forTable('t_judge')
            ->orderByAsc('id')
            ->findMany();

        if ($stage == Contest::STAGE_FINAL) {
            $query = <<<EOS
SELECT r.*, u.name_m, u.name_s
FROM t_regist_apply r LEFT JOIN t_member_regist u ON r.member_regist_no = u.member_regist_no
WHERE judge_status >= ?
ORDER BY regist_apply_no
LIMIT $offset, $limit
EOS;
            $entries = \ORM::forTable('t_regist_apply')
                ->rawQuery($query, [$stage - 1])
                ->findMany();
            $count = \ORM::forTable('t_regist_apply')
                ->whereGte('judge_status', $stage - 1)
                ->count();
        } else {
            if ($category) {
                if ($stage == Contest::STAGE_1ST_APPROVE ||
                    $stage == Contest::STAGE_2ND_APPROVE ||
                    $stage == Contest::STAGE_SEMI_FINAL_APPROVE) {
                    $query = <<<EOS
SELECT r.*, u.name_m, u.name_s, (SELECT IFNULL(SUM(point),0) FROM t_apply_points WHERE stage = ? AND regist_apply_no = r.regist_apply_no) AS point
FROM t_regist_apply r LEFT JOIN t_member_regist u ON r.member_regist_no = u.member_regist_no
WHERE apply_genre = ? AND judge_status >= ?
ORDER BY point DESC, regist_apply_no
LIMIT $offset, $limit
EOS;
                    $entries = \ORM::forTable('t_regist_apply')
                        ->rawQuery($query, [$stage - 1, $category, $stage - 1])
                        ->findMany();
                } elseif ($stage == Contest::STAGE_1ST_POINT ||
                          $stage == Contest::STAGE_2ND_POINT ||
                          $stage == Contest::STAGE_SEMI_FINAL_POINT) {
                    $query = <<<EOS
SELECT r.*, u.name_m, u.name_s
FROM t_regist_apply r LEFT JOIN t_member_regist u ON r.member_regist_no = u.member_regist_no
WHERE apply_genre = ? AND judge_status >= ?
ORDER BY regist_apply_no
LIMIT $offset, $limit
EOS;
                    $entries = \ORM::forTable('t_regist_apply')
                        ->rawQuery($query, [$category, $stage - 1])
                        ->findMany();
                }

                $count = \ORM::forTable('t_regist_apply')
                    ->where('apply_genre', $category)
                    ->whereGte('judge_status', $stage - 1)
                    ->count();
            }
        }

        $points = [];
        foreach ($entries as $entry) {
            $applyNo = $entry->regist_apply_no;
            foreach ($judges as $judge) {
                if (empty($points[$applyNo][$judge->id])) {
                    $points[$applyNo][$judge->id] = 0;
                }
            }
            $pointArr = ApplyPoint::getApplyPoints($applyNo, $stage);
            foreach ($pointArr as $point) {
                $points[$applyNo][$point->judge_id] = $point->point;
            }
        }

        $app->render(
            'manager/contest/index.php',
            [
                'app'        => $app,
                'category'   => $category,
                'stage'      => $stage,
                'page'       => $page,
                'pager'      => new Pager("/manager/contest/index?c={$category}&s={$stage}", $limit, $count, $page),
                'count'      => $count,
                'entries'    => $entries,
                'categories' => Category::getCategories(),
                'stages'     => Contest::$judgeStages,
                'judges'     => $judges,
                'points'     => $points,
            ]
        );
    }

    /**
     * ポイントを保存する.
     *
     * POST /contest/save
     */
    public static function save($app)
    {
        $category = $app->request->post('c');
        $stage    = $app->request->post('s');
        $page     = $app->request->post('page');

        if ($stage == Contest::STAGE_1ST_POINT ||
            $stage == Contest::STAGE_2ND_POINT ||
            $stage == Contest::STAGE_SEMI_FINAL_POINT) {
            $pointArray = $app->request->post('point');
            foreach ($pointArray as $applyNo => $points) {
                foreach ($points as $judgeId => $point) {
                    $applyPoint        = ApplyPoint::getApplyPoint($applyNo, $judgeId, $stage);
                    $applyPoint->point = $point;
                    $applyPoint->save();
                }
            }
            $messages = 'Saved.';
            $app->flash('messages', $messages);
        } elseif ($stage == Contest::STAGE_1ST_APPROVE ||
                $stage == Contest::STAGE_2ND_APPROVE ||
                $stage == Contest::STAGE_SEMI_FINAL_APPROVE) {
            $passArray = $app->request->post('pass');
            foreach ($passArray as $applyNo => $status) {
                $entry = \ORM::forTable('t_regist_apply')
                    ->where('regist_apply_no', $applyNo)
                    ->findOne();
                if ($entry) {
                    if ($status == 1) {
                        if ($entry->judge_status < $stage) {
                            $entry->judge_status = $stage + 1;
                            $entry->use_id_column('regist_apply_no');
                            $entry->save();
                        }
                    } elseif ($status == 0) {
                        $entry->judge_status = $stage - 1;
                        $entry->use_id_column('regist_apply_no');
                        $entry->save();
                    }
                }
            }
        } elseif ($stage == Contest::STAGE_FINAL) {
            $awardArray = $app->request->post('award');
            foreach ($awardArray as $applyNo => $awards) {
                $status = $stage;
                foreach ($awards as $award) {
                    $status += $award;
                }
                $entry = \ORM::forTable('t_regist_apply')
                    ->where('regist_apply_no', $applyNo)
                    ->findOne();
                if ($entry) {
                    $entry->judge_status = $status;
                    $entry->use_id_column('regist_apply_no');
                    $entry->save();
                }
            }
        }

        $app->redirect("/manager/contest/index?c={$category}&s={$stage}&page={$page}");
    }

    /**
     * コンテストの設定を表示する.
     *
     * GET /contest/setting
     */
    public static function showSetting($app)
    {
        $settings = \ORM::forTable('t_settings')->findMany();

        foreach ($settings as $setting) {
            // submit
            if ($setting->settings_key == 'TERM_START') {
                $start1 = $setting->settings_val;
            } elseif ($setting->settings_key == 'TERM_END') {
                $end1 = $setting->settings_val;
            } elseif ($setting->settings_key == 'TERM_TIMEZONE') {
                $timezone1 = $setting->settings_val;
            }
            // pay
            elseif ($setting->settings_key == 'PAY_START') {
                $start2 = $setting->settings_val;
            } elseif ($setting->settings_key == 'PAY_END') {
                $end2 = $setting->settings_val;
            } elseif ($setting->settings_key == 'PAY_TIMEZONE') {
                $timezone2 = $setting->settings_val;
            }
        }

        $app->render(
            'manager/contest/setting.php',
            [
                'app'       => $app,
                'start1'    => $start1,
                'end1'      => $end1,
                'timezone1' => $timezone1,
                'start2'    => $start2,
                'end2'      => $end2,
                'timezone2' => $timezone2,
            ]
        );
    }

    /**
     * コンテストの設定を更新する.
     *
     * POST /contest/setting
     */
    public static function saveSetting($app)
    {
        // submit
        $start1    = $app->request->post('start1');
        $end1      = $app->request->post('end1');
        $timezone1 = $app->request->post('timezone1');

        if (!empty($start1)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'TERM_START')->findOne();
            if ($setting) {
                $setting->settings_val = $start1;
                $setting->save();
            }
        }
        if (!empty($end1)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'TERM_END')->findOne();
            if ($setting) {
                $setting->settings_val = $end1;
                $setting->save();
            }
        }
        if (!empty($timezone1)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'TERM_TIMEZONE')->findOne();
            if ($setting) {
                $setting->settings_val = $timezone1;
                $setting->save();
            }
        }

        // pay
        $start2    = $app->request->post('start2');
        $end2      = $app->request->post('end2');
        $timezone2 = $app->request->post('timezone2');

        if (!empty($start2)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'PAY_START')->findOne();
            if ($setting) {
                $setting->settings_val = $start2;
                $setting->save();
            }
        }
        if (!empty($end2)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'PAY_END')->findOne();
            if ($setting) {
                $setting->settings_val = $end2;
                $setting->save();
            }
        }
        if (!empty($timezone2)) {
            $setting = \ORM::forTable('t_settings')->where('settings_key', 'PAY_TIMEZONE')->findOne();
            if ($setting) {
                $setting->settings_val = $timezone2;
                $setting->save();
            }
        }

        $app->flash('messages', 'Success to update contest settings.');
        $app->redirect('/manager/contest/setting');
    }
}
