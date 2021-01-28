<?php

/**
 * @version SVN: $Id: EntryController.php 162 2015-09-02 07:19:37Z morita $
 */
namespace NBPA\Controllers;

use NBPA\Models\Category;
use NBPA\Models\Message;
use NBPA\Models\Contest;
use NBPA\Services\TemplateService;
use NBPA\Services\EntryService;
use NBPA\Services\PaymentService;
use NBPA\Services\SettingService;
use NBPA\Services\ValidationService as vs;

class EntryController
{
    // サムネイルの長辺
    const THUMBNAIL_LONG_SIDE = 160;

    /**
     * 画像を表示する.
     *
     * GET /entry/image/:id
     */
    public static function image($app, $id)
    {
        $registApplyNo = $id;

        $imgDir = $app->config('images.path');

        if ($id === 'temporary') {
            // via Session
            $t        = $app->request->get('t');
            $category = $_SESSION['category' . $t];
            $catName  = Category::getCategoryName($category);
            $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $_SESSION['file.name' . $t];
            if (file_exists($filename)) {
                header('Content-Type: image/jpeg');
                readfile($filename);
            }
        } else {
            // via DB
            $entry = EntryService::getEntry($app->member->member_regist_no, $id);
            if ($entry) {
                $category = $entry->apply_genre;
                $catName  = Category::getCategoryName($category);
                $filename = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $entry->apply_image;
                if (file_exists($filename)) {
                    header('Content-Type: image/jpeg');
                    readfile($filename);
                }
            }
        }
    }

    /**
     * 作品応募画面を表示する.
     *
     * GET /entry/entry
     */
    public static function entry($app)
    {
        $member         = $app->member;
        $memberRegistNo = $member->member_regist_no;

        $t = $app->request->get('t');
        if (!isset($t)) {
            $t = uniqid(chr(mt_rand(ord('a'), ord('z'))));
            $app->redirect("/user/entry/entry?t={$t}");
        }

        // カテゴリ毎の応募数を取得する。
        $entries          = EntryService::getPictureEnteredSummary($memberRegistNo);
        $pictureEntered   = $entries['total'];
        $picturePurchased = PaymentService::getPicturePurchased($memberRegistNo);

        // 応募可能残数を確認する。
        if ($picturePurchased - $pictureEntered <= 0) {
            $app->flash('error', [Message::getMessage(Message::MSG_NO_PHOTO_YOU_CAN_ENTRY)]);
            $app->redirect('/user/member/home');
        }

        // 開催期間か判定する。
        $termStart    = SettingService::getTermStart();
        $termEnd      = SettingService::getTermEnd();
        $termTimezone = SettingService::getTermTimezone();
        $inTerm       = SettingService::inTerm($termStart, $termEnd, $termTimezone);
        if ($inTerm === 0) {
            $app->flash('error', [Message::getMessage(Message::MSG_PERIOD_HAS_ENDED)]);
            $app->redirect('/user/member/home');
        }

        $category  = isset($_SESSION['category' . $t]) ? $_SESSION['category' . $t] : 0;
        $title     = isset($_SESSION['title' . $t]) ? $_SESSION['title' . $t] : '';
        $filename  = '';
        $embedcode = isset($_SESSION['embedcode' . $t]) ? $_SESSION['embedcode' . $t] : '';

        $app->render(
            TemplateService::getTemplatePath('entry/entry.php'),
            [
                'app' => $app,

                't' => $t,

                'categories' => Category::getCategories(),

                'category'  => $category,
                'title'     => $title,
                'filename'  => $filename,
                'embedcode' => $embedcode,
            ]
        );
    }

    /**
     * 作品応募確認画面を表示する.
     *
     * POST /entry/entry
     */
    public static function entryConfirmation($app)
    {
        $t = $app->request->post('t');

        $back = $app->request->post('back');
        if ($back) {
            // unset session
            unset($_SESSION['category' . $t]);
            unset($_SESSION['title' . $t]);
            unset($_SESSION['embedcode' . $t]);
            unset($_SESSION['file.org' . $t]);
            unset($_SESSION['file.size' . $t]);
            unset($_SESSION['file.type' . $t]);
            unset($_SESSION['file.name' . $t]);

            $app->redirect('/user/member/home');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            $member = $app->member;

            $category  = $app->request->post('category');
            $title     = $app->request->post('title');
            $embedcode = $app->request->post('embedcode');

            // save values to the session
            $_SESSION['category' . $t]  = $category;
            $_SESSION['title' . $t]     = $title;
            $_SESSION['embedcode' . $t] = $embedcode;

            $agreement = $app->request->post('agreement');
            $agreement = isset($agreement) ? true : false;

            $files = isset($_FILES['filename']) ? $_FILES['filename'] : null;

            if ($category != 6 && !$files) {
                $app->flash('error', [Message::getMessage(Message::MSG_NO_FILE_UPLOADED)]);
                $app->redirect("/user/entry/entry?t={$t}");
            }

            $errors = [];
            if ($agreement) {
                if ($category == 6) { // Movie
                    // validation
                    // title
                    if ($error = vs::validateTitle($title)) {
                        $errors = array_merge($errors, $error);
                    }
                    // embedcode
                    if ($error = vs::validateEmbedcode($embedcode)) {
                        $errors = array_merge($errors, $error);
                    }
                } else { // Photo
                    if ($files['error'] == UPLOAD_ERR_OK) {
                        $orgName  = $files['name'];
                        $tmpName  = $files['tmp_name'];
                        $fileSize = $files['size'];
                        $fileType = $files['type']; // image/jpeg

                        // validation
                        // title
                        if ($error = vs::validateTitle($title)) {
                            $errors = array_merge($errors, $error);
                        }

                        // move temporary file
                        $catName = Category::getCategoryName($category);
                        $imgHash = uniqid(mt_rand());
                        $imgDir  = $app->config('images.path');
                        $imgName = sprintf(
                            '%s_%d_%s_%s_%s_%s.jpg',
                            $catName,
                            $member->member_regist_no,
                            $member->name_s,
                            $member->name_m,
                            $title,
                            $imgHash
                        );
                        if (!file_exists($imgDir . DIRECTORY_SEPARATOR . $catName)) {
                            mkdir($imgDir . DIRECTORY_SEPARATOR . $catName);
                        }
                        $imgDst = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $imgName;
                        if (!move_uploaded_file($tmpName, $imgDst)) {
                            $errors[] = Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR);
                        } else {
                            // thumbnail
                            $thumbnailDir = $app->config('thumbnails.path');
                            $app->log->debug('dir=' . $thumbnailDir . DIRECTORY_SEPARATOR . $catName);
                            if (!file_exists($thumbnailDir . DIRECTORY_SEPARATOR . $catName)) {
                                mkdir($thumbnailDir . DIRECTORY_SEPARATOR . $catName);
                            }
                            $thumbnailDst = $thumbnailDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $imgName;
                            $in           = imagecreatefromjpeg($imgDst);
                            if ($in) {
                                $w = imagesx($in);
                                $h = imagesy($in);
                                if ($w > $h) {
                                    $sw = self::THUMBNAIL_LONG_SIDE;
                                    $sh = (int) ($h / ($w / self::THUMBNAIL_LONG_SIDE));
                                } else {
                                    $sw = (int) ($w / ($h / self::THUMBNAIL_LONG_SIDE));
                                    $sh = self::THUMBNAIL_LONG_SIDE;
                                }
                                $out = imagecreatetruecolor($sw, $sh);
                                imagecopyresampled($out, $in, 0, 0, 0, 0, $sw, $sh, $w, $h);
                                imagejpeg($out, $thumbnailDst);
                            }
                        }
                    } else {
                        $errors[] = sprintf(Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR) . ' [%d]', $files['error']);
                    }
                }
            } else {
                $errors[] = Message::getMessage(Message::MSG_PLEASE_AGREE_TO_THE_CONDITIONS);
            }

            if (!empty($errors)) {
                $app->flash('error', $errors);
                $app->redirect("/user/entry/entry?t={$t}");
            }

            // save values to the session
            $_SESSION['file.org' . $t]  = isset($orgName) ? $orgName : null;
            $_SESSION['file.size' . $t] = isset($fileSize) ? $fileSize : 0;
            $_SESSION['file.type' . $t] = isset($fileType) ? $fileType : null;
            $_SESSION['file.name' . $t] = isset($imgName) ? $imgName : null;

            $app->response->headers->set('X-XSS-Protection', 0); // WebKit

            $app->render(
                TemplateService::getTemplatePath('entry/entry_confirm.php'),
                [
                    'app' => $app,

                    't' => $t,

                    'categories' => Category::getCategories(),

                    'category'  => $category,
                    'title'     => $title,
                    'embedcode' => $embedcode,
                ]
            );
        }
    }

    /**
     * 作品応募処理.
     *
     * PUT /entry/entry
     */
    public static function entryProcess($app)
    {
        $t = $app->request->put('t');

        $back = $app->request->put('back');
        if ($back) {
            $app->redirect("/user/entry/entry?t={$t}");
        }

        $entry = $app->request->put('entry'); // submit
        if ($entry) {
            $category  = $_SESSION['category' . $t];
            $title     = $_SESSION['title' . $t];
            $embedcode = $_SESSION['embedcode' . $t];
            $imgName   = $_SESSION['file.name' . $t];

            $member         = $app->member;
            $memberRegistNo = $member->member_regist_no;

            // カテゴリ毎の応募数を取得する。
            $entries          = EntryService::getPictureEnteredSummary($memberRegistNo);
            $pictureEntered   = $entries['total'];
            $picturePurchased = PaymentService::getPicturePurchased($memberRegistNo);

            // 応募可能残数を確認する。
            if ($picturePurchased - $pictureEntered <= 0) {
                $app->flash('error', [Message::getMessage(Message::MSG_NO_PHOTO_YOU_CAN_ENTRY)]);
                $app->redirect('/user/member/home');
            }

            // validation
            $errors = [];
            // title
            if ($error = vs::validateTitle($title)) {
                $errors = array_merge($errors, $error);
            }

            if ($category == 6) { // Movie
                if ($error = vs::validateEmbedcode($embedcode)) {
                    $errors = array_merge($errors, $error);
                } else {
                    $imgName = $embedcode;
                }
            }

            if (empty($errors)) {
                // save to database
                $remoteAddr = $_SERVER['REMOTE_ADDR'];

                EntryService::newEntry(
                    $remoteAddr,
                    $memberRegistNo,
                    $category,
                    $imgName,
                    $title
                );

                // unset session
                unset($_SESSION['category' . $t]);
                unset($_SESSION['title' . $t]);
                unset($_SESSION['embedcode' . $t]);
                unset($_SESSION['file.org' . $t]);
                unset($_SESSION['file.size' . $t]);
                unset($_SESSION['file.type' . $t]);
                unset($_SESSION['file.name' . $t]);

                $app->redirect('/user/entry/complete');
            } else {
                $app->flash('error', $errors);
                $app->redirect("/user/entry/entry?t={$t}");
            }
        }
    }

    /**
     * 作品応募完了画面を表示する.
     *
     * GET /entry/entry/complete
     */
    public static function entryComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('entry/entry_complete.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * 応募作品の一覧を表示する.
     *
     * GET /entry/list/:categoryId
     */
    public static function listByCategory($app, $categoryId)
    {
        $items = EntryService::getEntriesByCategory($app->member->member_regist_no, $categoryId);

        if (empty($items)) {
            $app->redirect('/user/member/home');
        } else {
            $termStart    = SettingService::getTermStart();
            $termEnd      = SettingService::getTermEnd();
            $termTimezone = SettingService::getTermTimezone();
            $inTerm       = SettingService::inTerm($termStart, $termEnd, $termTimezone);
            $app->render(
                TemplateService::getTemplatePath('entry/list.php'),
                [
                    'app' => $app,

                    'categories' => Category::getCategories(),

                    'category' => $categoryId,

                    'items' => $items,

                    'inTerm' => $inTerm,
                ]
            );
        }
    }

    /**
     * 応募作品の一覧を更新する.
     *
     * POST /entry/list/:categoryId
     */
    public static function updateList($app, $categoryId)
    {
        $back = $app->request->post('back');
        if ($back) {
            $app->redirect('/user/member/home');
        }
        $drop = $app->request->post('drop');
        if ($drop) {
            $drops = $app->request->post('drops');
            if (!empty($drops)) {
                EntryService::dropEntries($app->member->member_regist_no, $drops);
            }
            $app->redirect("/user/entry/list/{$categoryId}");
        }
    }

    /**
     * ハイレゾ作品の応募フォームを表示する.
     *
     * GET /entry/hires/:id
     */
    public static function hires($app, $id)
    {
        $t = $app->request->get('t');
        if (!isset($t)) {
            $t = uniqid(chr(mt_rand(ord('a'), ord('z'))));
            $app->redirect("/user/entry/hires/{$id}?t={$t}");
        }

        $member         = $app->member;
        $memberRegistNo = $member->member_regist_no;
        $registApplyNo  = $id;

        // id の存在と所有者を確認する.
        $entry = EntryService::getEntry($memberRegistNo, $registApplyNo);
        if (!$entry) {
            $app->flash('error', ['Invalid entry ID.']);
            $app->redirect('/user/member/home');
        }
        // judge_status を確認する.
        if ($entry->judge_status < Contest::STAGE_SEMI_FINAL_POINT) {
            $app->flash('error', ['Invalid entry ID.']);
            $app->redirect('/user/member/home');
        }

        $entry->photo_place   = isset($_SESSION['location' . $t]) ? $_SESSION['location' . $t] : $entry->photo_place;
        $entry->camera        = isset($_SESSION['cmodel' . $t]) ? $_SESSION['cmodel' . $t] : $entry->camera;
        $entry->lens          = isset($_SESSION['lmodel' . $t]) ? $_SESSION['lmodel' . $t] : $entry->lens;
        $entry->ss            = isset($_SESSION['sspeed' . $t]) ? $_SESSION['sspeed' . $t] : $entry->ss;
        $entry->f_num         = isset($_SESSION['fnum' . $t]) ? $_SESSION['fnum' . $t] : $entry->f_num;
        $entry->iso           = isset($_SESSION['fspeed' . $t]) ? $_SESSION['fspeed' . $t] : $entry->iso;
        $entry->flash         = isset($_SESSION['fmodel' . $t]) ? $_SESSION['fmodel' . $t] : $entry->flash;
        $entry->tripod        = isset($_SESSION['tmodel' . $t]) ? $_SESSION['tmodel' . $t] : $entry->tripod;
        $entry->photo_comment = isset($_SESSION['comment' . $t]) ? $_SESSION['comment' . $t] : $entry->photo_comment;

        $app->render(
            TemplateService::getTemplatePath('entry/hires.php'),
            [
                'app'        => $app,
                't'          => $t,
                'id'         => $id,
                'categories' => Category::getCategories(),
                'entry'      => $entry,
            ]
        );
    }

    /**
     * ハイレゾ作品応募確認画面を表示する.
     */
    public static function hiresConfirmation($app)
    {
        $t  = $app->request->post('t');
        $id = $app->request->post('id');

        $back = $app->request->post('back');
        if ($back) {
            // unset session
            unset($_SESSION['location' . $t]);
            unset($_SESSION['cmodel' . $t]);
            unset($_SESSION['lmodel' . $t]);
            unset($_SESSION['sspeed' . $t]);
            unset($_SESSION['fnum' . $t]);
            unset($_SESSION['fspeed' . $t]);
            unset($_SESSION['fmodel' . $t]);
            unset($_SESSION['tmodel' . $t]);
            unset($_SESSION['comment' . $t]);
            unset($_SESSION['img.name' . $t]);
            unset($_SESSION['raw.name' . $t]);

            $app->redirect('/user/member/home');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            $member         = $app->member;
            $memberRegistNo = $member->member_regist_no;
            $registApplyNo  = $id;

            // id の存在と所有者を確認する.
            $entry = EntryService::getEntry($memberRegistNo, $registApplyNo);
            if (!$entry) {
                $app->flash('error', ['Invalid entry ID.']);
                $app->redirect('/user/member/home');
            }
            // judge_status を確認する.
            if ($entry->judge_status < Contest::STAGE_SEMI_FINAL_POINT) {
                $app->flash('error', ['Invalid entry ID.']);
                $app->redirect('/user/member/home');
            }

            $title    = $entry->image_title;
            $category = $entry->apply_genre;

            $location = $app->request->post('location');
            $cmodel   = $app->request->post('cmodel');
            $lmodel   = $app->request->post('lmodel');
            $sspeed   = $app->request->post('sspeed');
            $fnum     = $app->request->post('fnum');
            $fspeed   = $app->request->post('fspeed');
            $fmodel   = $app->request->post('fmodel');
            $tmodel   = $app->request->post('tmodel');
            $comment  = $app->request->post('comment');

            // save values to the session
            $_SESSION['location' . $t] = $location;
            $_SESSION['cmodel' . $t]   = $cmodel;
            $_SESSION['lmodel' . $t]   = $lmodel;
            $_SESSION['sspeed' . $t]   = $sspeed;
            $_SESSION['fnum' . $t]     = $fnum;
            $_SESSION['fspeed' . $t]   = $fspeed;
            $_SESSION['fmodel' . $t]   = $fmodel;
            $_SESSION['tmodel' . $t]   = $tmodel;
            $_SESSION['comment' . $t]  = $comment;

            $entry->photo_place   = $location;
            $entry->camera        = $cmodel;
            $entry->lens          = $lmodel;
            $entry->ss            = $sspeed;
            $entry->f_num         = $fnum;
            $entry->iso           = $fspeed;
            $entry->flash         = $fmodel;
            $entry->tripod        = $tmodel;
            $entry->photo_comment = $comment;

            $hrimage = isset($_FILES['hrimage']) ? $_FILES['hrimage'] : null;
            $rawfile = isset($_FILES['rawfile']) ? $_FILES['rawfile'] : null;

            if (!$hrimage) {
                $app->flash('error', [Message::getMessage(Message::MSG_NO_FILE_UPLOADED)]);
                $app->redirect("/user/entry/hires/{$id}?t={$t}");
            }
            /*
            if (!$rawfile) {
                $app->flash('error', array(Message::getMessage(Message::MSG_NO_FILE_UPLOADED)));
                $app->redirect("/user/entry/hires/{$id}?t={$t}");
            }
             */

            // HiRes
            $imgName = '';
            $imgOrig = '';
            $imgSize = 0;
            // RAW
            $rawName = '';
            $rawOrig = '';
            $rawSize = 0;

            $errors = [];
            if ($hrimage['error'] == UPLOAD_ERR_OK) {
                $tmpName = $hrimage['tmp_name'];
                $imgOrig = $hrimage['name'];
                $parts   = pathinfo($imgOrig);
                $extName = $parts['extension'];
                $imgSize = $hrimage['size'];

                // move temporary file
                $catName = Category::getCategoryName($category);
                $imgHash = uniqid(mt_rand());
                $imgDir  = $app->config('hrimages.path');
                $imgName = sprintf(
                    '%s_%d_%s_%s_%s_%s.%s',
                    $catName,
                    $member->member_regist_no,
                    $member->name_s,
                    $member->name_m,
                    $title,
                    $imgHash,
                    $extName
                );
                if (!file_exists($imgDir . DIRECTORY_SEPARATOR . $catName)) {
                    mkdir($imgDir . DIRECTORY_SEPARATOR . $catName);
                }
                $imgDst = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $imgName;
                if (!move_uploaded_file($tmpName, $imgDst)) {
                    $errors[] = Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR);
                }
            } else {
                $errors[] = sprintf(Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR) . ' [HiRes:%d]', $hrimage['error']);
            }
            if ($rawfile['error'] == UPLOAD_ERR_OK) {
                $tmpName = $rawfile['tmp_name'];
                $rawOrig = $rawfile['name'];
                $parts   = pathinfo($rawOrig);
                $extName = $parts['extension'];
                $rawSize = $rawfile['size'];

                // move temporary file
                $catName = Category::getCategoryName($category);
                $imgHash = uniqid(mt_rand());
                $imgDir  = $app->config('rawfiles.path');
                $rawName = sprintf(
                    '%s_%d_%s_%s_%s_%s.%s',
                    $catName,
                    $member->member_regist_no,
                    $member->name_s,
                    $member->name_m,
                    $title,
                    $imgHash,
                    $extName
                );
                if (!file_exists($imgDir . DIRECTORY_SEPARATOR . $catName)) {
                    mkdir($imgDir . DIRECTORY_SEPARATOR . $catName);
                }
                $imgDst = $imgDir . DIRECTORY_SEPARATOR . $catName . DIRECTORY_SEPARATOR . $rawName;
                if (!move_uploaded_file($tmpName, $imgDst)) {
                    $errors[] = Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR);
                }
            } elseif ($rawfile['error'] != UPLOAD_ERR_NO_FILE) {
                $errors[] = sprintf(Message::getMessage(Message::MSG_FILE_UPLOAD_ERROR) . ' [RAW:%d]', $rawfile['error']);
            }

            // save values to the session
            $_SESSION['img.name' . $t] = $imgName;
            $_SESSION['raw.name' . $t] = $rawName;

            // validation
            if ($error = vs::validateLocation($location)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateCamera($cmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateLens($lmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateSpeed($sspeed)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateFnum($fnum)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateISO($fspeed)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateFlash($fmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateTripod($tmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateComment($comment)) {
                $errors = array_merge($errors, $error);
            }

            if (!empty($errors)) {
                $app->flash('error', $errors);
                $app->redirect("/user/entry/hires/{$id}?t={$t}");
            }

            $app->render(
                TemplateService::getTemplatePath('entry/hires_confirm.php'),
                [
                    'app'        => $app,
                    't'          => $t,
                    'id'         => $id,
                    'categories' => Category::getCategories(),
                    'entry'      => $entry,
                    'imgOrig'    => $imgOrig,
                    'imgSize'    => $imgSize,
                    'rawOrig'    => $rawOrig,
                    'rawSize'    => $rawSize,
                ]
            );
        }
    }

    /**
     * ハイレゾ作品応募処理.
     */
    public static function hiresProcess($app)
    {
        $t  = $app->request->put('t');
        $id = $app->request->put('id');

        $back = $app->request->put('back');
        if ($back) {
            $app->redirect("/user/entry/hires/{$id}?t={$t}");
        }

        $entry = $app->request->put('entry');
        if ($entry) {
            $member         = $app->member;
            $memberRegistNo = $member->member_regist_no;
            $registApplyNo  = $id;

            // id の存在と所有者を確認する.
            $entry = EntryService::getEntry($memberRegistNo, $registApplyNo);
            if (!$entry) {
                $app->flash('error', ['Invalid entry ID.']);
                $app->redirect('/user/member/home');
            }
            // judge_status を確認する.
            if ($entry->judge_status < Contest::STAGE_SEMI_FINAL_POINT) {
                $app->flash('error', ['Invalid entry ID.']);
                $app->redirect('/user/member/home');
            }

            $location = $_SESSION['location' . $t];
            $cmodel   = $_SESSION['cmodel' . $t];
            $lmodel   = $_SESSION['lmodel' . $t];
            $sspeed   = $_SESSION['sspeed' . $t];
            $fnum     = $_SESSION['fnum' . $t];
            $fspeed   = $_SESSION['fspeed' . $t];
            $fmodel   = $_SESSION['fmodel' . $t];
            $tmodel   = $_SESSION['tmodel' . $t];
            $comment  = $_SESSION['comment' . $t];
            $imgName  = $_SESSION['img.name' . $t];
            $rawName  = $_SESSION['raw.name' . $t];

            // validation
            $errors = [];
            if ($error = vs::validateLocation($location)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateCamera($cmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateLens($lmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateSpeed($sspeed)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateFnum($fnum)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateISO($fspeed)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateFlash($fmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateTripod($tmodel)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateComment($comment)) {
                $errors = array_merge($errors, $error);
            }

            if (empty($errors)) {
                // save to database
                $entry->photo_place        = $location;
                $entry->camera             = $cmodel;
                $entry->lens               = $lmodel;
                $entry->ss                 = $sspeed;
                $entry->f_num              = $fnum;
                $entry->iso                = $fspeed;
                $entry->flash              = $fmodel;
                $entry->tripod             = $tmodel;
                $entry->photo_comment      = $comment;
                $entry->highres_photo_name = $imgName;
                $entry->raw_file           = $rawName;
                $entry->revision_date      = date('Y-m-d H:i:s');

                $entry->use_id_column('regist_apply_no');
                $entry->save();

                // unset session
                unset($_SESSION['location' . $t]);
                unset($_SESSION['cmodel' . $t]);
                unset($_SESSION['lmodel' . $t]);
                unset($_SESSION['sspeed' . $t]);
                unset($_SESSION['fnum' . $t]);
                unset($_SESSION['fspeed' . $t]);
                unset($_SESSION['fmodel' . $t]);
                unset($_SESSION['tmodel' . $t]);
                unset($_SESSION['comment' . $t]);
                unset($_SESSION['img.name' . $t]);
                unset($_SESSION['raw.name' . $t]);

                $app->redirect('/user/entry/hirescomplete');
            } else {
                $app->flash('error', $errors);
                $app->redirect("/user/entry/hires/{$id}?t={$t}");
            }
        }
    }

    /**
     * ハイレゾ作品応募完了画面を表示する.
     */
    public static function hiresComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('entry/hires_complete.php'),
            [
                'app' => $app,
            ]
        );
    }
}
