<?php

/**
 * @version SVN: $Id: EntryController.php 149 2015-06-16 06:30:15Z morita $
 */
namespace NBPA\Controllers\Manager;

use NBPA\Models\Pager;
use NBPA\Models\Category;
use NBPA\Services\EntryService;
use NBPA\Services\MemberService;
use NBPA\Services\ValidationService as vs;

class EntryController
{
    const LIMIT = 25;

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
     * 画像をダウンロードする.
     *
     * GET /entry/download/:uid/:id
     */
    public static function download($app, $uid, $id)
    {
        $imgDir = $app->config('images.path');

        $entry = EntryService::getEntry($uid, $id);
        if ($entry) {
            $category = $entry->apply_genre;
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->apply_image;
            if (file_exists($filename)) {
                $app->response->headers->set('Content-Type', 'application/octet-stream');
                $app->response->headers->set('Content-Disposition', 'attachment; filename="' . basename($filename) . '"');
                readfile($filename);
            }
        }
    }

    /**
     * ハイレゾ画像をダウンロードする.
     *
     * GET /entry/hiresdownload/:uid/:id
     */
    public static function downloadHiRes($app, $uid, $id)
    {
        $imgDir = $app->config('hrimages.path');

        $entry = EntryService::getEntry($uid, $id);
        if ($entry) {
            $category = $entry->apply_genre;
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->highres_photo_name;
            if (file_exists($filename)) {
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

		while (ob_get_level()) { ob_end_clean(); }

                readfile($filename);
            }
        }
    }

    /**
     * RAW 画像をダウンロードする.
     *
     * GET /entry/rawdownload/:uid/:id
     */
    public static function downloadRaw($app, $uid, $id)
    {
        $imgDir = $app->config('rawfiles.path');

        $entry = EntryService::getEntry($uid, $id);
        if ($entry) {
            $category = $entry->apply_genre;
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->raw_file;
            if (file_exists($filename)) {
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

		while (ob_get_level()) { ob_end_clean(); }

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
        // Search keyword
        $q = $app->request->get('q');

        // Category
        $c = $app->request->get('c');
        $c = isset($c) ? (int) $c : 0;

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
                $clause .= 'image_title LIKE ? OR r.member_regist_no = ?';
                $parameters[] = "%{$q}%";
                $parameters[] = "{$q}";

                if ($c > 0) {
                    $clause .= ' AND apply_genre = ?';
                    $parameters[] = "{$c}";
                }
            } else {
                if ($c > 0) {
                    $clause .= 'apply_genre = ?';
                    $parameters[] = "{$c}";
                }
            }
        }

        if (strlen($clause) > 0) {
            $entries = \ORM::forTable('t_regist_apply')
                ->tableAlias('r')
                ->select('r.*')
                ->select('u.name_m')
                ->select('u.name_s')
                ->join('t_member_regist', ['r.member_regist_no', '=', 'u.member_regist_no'], 'u')
                ->whereRaw($clause, $parameters)
                ->offset($offset)
                ->limit($limit)
                ->orderByDesc('regist_apply_no')
                ->findMany();
            $count = \ORM::forTable('t_regist_apply')
                ->tableAlias('r')
                ->whereRaw($clause, $parameters)
                ->count();
        } else {
            $entries = \ORM::forTable('t_regist_apply')
                ->tableAlias('r')
                ->select('r.*')
                ->select('u.name_m')
                ->select('u.name_s')
                ->join('t_member_regist', ['r.member_regist_no', '=', 'u.member_regist_no'], 'u')
                ->offset($offset)
                ->limit($limit)
                ->orderByDesc('regist_apply_no')
                ->findMany();
            $count = \ORM::forTable('t_regist_apply')
                ->count();
        }

        $app->render(
            'manager/entry/index.php',
            [
                'app'        => $app,
                'q'          => $q,
                'c'          => $c,
                'page'       => $page,
                'pager'      => new Pager("/manager/entry/index?c={$c}&q={$q}", $limit, $count, $page),
                'count'      => $count,
                'entries'    => $entries,
                'categories' => Category::getCategories(),
            ]
        );
    }

    /**
     * 応募詳細画面を表示する.
     *
     * GET /entry/show/:uid/:id
     */
    public static function show($app, $uid, $id)
    {
        $q = $app->request->get('q');
        $c = $app->request->get('c');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $entry = EntryService::getEntry($uid, $id);

        $member = MemberService::getMemberByMemberRegistNo($uid);

        $app->render(
            'manager/entry/show.php',
            [
                'app'        => $app,
                'q'          => $q,
                'c'          => $c,
                'page'       => $page,
                'entry'      => $entry,
                'member'     => $member,
                'categories' => Category::getCategories(),
            ]
        );
    }

    /**
     * 応募編集画面を表示する.
     *
     * GET /entry/edit/:uid/:id
     */
    public static function edit($app, $uid, $id)
    {
        $q = $app->request->get('q');
        $c = $app->request->get('c');

        $page = $app->request->get('page');
        $page = isset($page) ? (int) $page : 0;

        $entry = EntryService::getEntry($uid, $id);

        $app->render(
            'manager/entry/edit.php',
            [
                'app'        => $app,
                'q'          => $q,
                'c'          => $c,
                'page'       => $page,
                'entry'      => $entry,
                'categories' => Category::getCategories(),
            ]
        );
    }

    /**
     * 応募情報を更新する.
     *
     * POST /entry/edit
     */
    public static function save($app)
    {
        $uid  = $app->request->post('uid');
        $id   = $app->request->post('id');
        $q    = $app->request->post('q');
        $c    = $app->request->post('c');
        $page = $app->request->post('page');

        $entry = EntryService::getEntry($uid, $id);

        $action = $app->request->post('action');
        if ($action == 'save') {
            $applyGenre   = $app->request->post('apply_genre');
            $imageTitle   = $app->request->post('image_title');
            $judgeStatus  = $app->request->post('judge_status');
            $staffComment = $app->request->post('staff_comment');
            $photoPlace   = $app->request->post('photo_place');
            $camera       = $app->request->post('camera');
            $lens         = $app->request->post('lens');
            $ss           = $app->request->post('ss');
            $Fnum         = $app->request->post('f_num');
            $iso          = $app->request->post('iso');
            $flash        = $app->request->post('flash');
            $tripod       = $app->request->post('tripod');
            $photoComment = $app->request->post('photo_comment');

            // validation
            $errors = [];
            // title
            if ($error = vs::validateTitle($imageTitle)) {
                $errors = array_merge($errors, $error);
            }

            $entry->apply_genre   = $applyGenre;
            $entry->image_title   = $imageTitle;
            $entry->judge_status  = $judgeStatus;
            $entry->staff_comment = $staffComment;
            $entry->photo_place   = $photoPlace;
            $entry->camera        = $camera;
            $entry->lens          = $lens;
            $entry->ss            = $ss;
            $entry->f_num         = $Fnum;
            $entry->iso           = $iso;
            $entry->flash         = $flash;
            $entry->tripod        = $tripod;
            $entry->photo_comment = $photoComment;

            if (!empty($errors)) {
                $app->flashNow('errors', $errors);
                $app->render(
                    'manager/entry/edit.php',
                    [
                        'app'        => $app,
                        'q'          => $q,
                        'c'          => $c,
                        'page'       => $page,
                        'entry'      => $entry,
                        'categories' => Category::getCategories(),
                    ]
                );
            } else {
                // save
                $entry->use_id_column('regist_apply_no');
                $entry->save();

                $app->flash('message', 'Storing entry data has completed.');
                $app->redirect("/manager/entry/show/{$uid}/{$id}?c={$c}&q={$q}&page={$page}");
            }
        }
    }
}
