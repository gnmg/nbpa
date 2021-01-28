<?php

/**
 * メンバー関係のコントローラー.
 *
 * @version SVN: $Id: MemberController.php 162 2015-09-02 07:19:37Z morita $
 */
namespace NBPA\Controllers;

use NBPA\Models\Country;
use NBPA\Models\Gender;
use NBPA\Models\Enquete;
use NBPA\Models\Category;
use NBPA\Models\Message;
use NBPA\Services\TemplateService;
use NBPA\Services\MemberService;
use NBPA\Services\PaymentService;
use NBPA\Services\EntryService;
use NBPA\Services\SessionService;
use NBPA\Services\CookieService;
use NBPA\Services\MailService;
use NBPA\Services\SettingService;
use NBPA\Services\ValidationService as vs;

class MemberController
{
    // 30分
    const TIME_THRESHOLD = 1800;

    /**
     * ログオン画面を表示する.
     *
     * GET /member/logon
     */
    public static function logon($app)
    {
        // 認証済みの場合はホーム画面へ。
        if ($app->member) {
            $app->redirect('/user/member/home');
        } else {
            $app->render(
                TemplateService::getTemplatePath('member/logon.php'),
                [
                    'app' => $app,
                ]
            );
        }
    }

    /**
     * ログオン認証をする.
     *
     * POST /member/logon
     */
    public static function authenticateMember($app)
    {
        $mail     = $app->request->post('user_id');
        $password = $app->request->post('password');

        $eternalLogin = $app->request->post('eternal_login');
        $eternalLogin = isset($eternalLogin) ? true : false;

        // validation
        $errors = [];
        if ($error = vs::validateEmail($mail)) {
            $errors = array_merge($errors, $error);
        }
        if ($error = vs::validatePassword($password)) {
            $errors = array_merge($errors, $error);
        }
        if (!empty($errors)) {
            $app->flash('error', [Message::getMessage(Message::MSG_EMAIL_ADDRESS_OR_PASSWORD_IS_NOT_CORRECT)]);
            $app->redirect('/user/member/logon');
        }

        // ユーザー認証する。
        if (MemberService::authenticateMember($mail, $password)) {
            $member = MemberService::getMemberByMail($mail);
            if ($member) {
                $memberRegistNo = $member->member_regist_no;
                SessionService::setMemberRegistNo($memberRegistNo);
                if ($eternalLogin) {
                    $encrypted = MemberService::encryptMemberNo($memberRegistNo);
                    CookieService::setMemberRegistNo($encrypted);
                }
            }
            $app->redirect('/user/member/home');
        } else {
            $app->flash('error', [Message::getMessage(Message::MSG_EMAIL_ADDRESS_OR_PASSWORD_IS_NOT_CORRECT)]);
            $app->redirect('/user/member/logon');
        }
    }

    /**
     * ホーム画面を表示する.
     *
     * GET /member/home
     */
    public static function home($app)
    {
        $member         = $app->member;
        $memberRegistNo = $member->member_regist_no;

        $name = $member->name_s . ' ' . $member->name_m;
        $mail = $member->mail;

        // カテゴリ毎の応募数を取得する。
        $entries = EntryService::getPictureEnteredSummary($memberRegistNo);

        $status = [];
        foreach (Category::getCategories() as $categoryId => $categoryName) {
            $status[$categoryId]['name']          = $categoryName;
            $status[$categoryId]['entered_count'] = $entries[$categoryId];
        }

        // クレジットカード決済のための参照文字列を生成する。
        $orderRef = PaymentService::getRefNumber($memberRegistNo);
       

        // 設定ファイルからカード決済の設定を参照する。
        $paymentEndpoint    = $app->settings['payment.endpoint'];
        $paymentMerchantId  = $app->settings['payment.merchant.id'];
        $paymentCurrency    = $app->settings['payment.currency'];
        $paymentAmount      = $app->settings['payment.amount'];
        $paymentAmountYouth = $app->settings['payment.amount.youth'];
        $paymentSuccessUrl  = $app->settings['payment.success.url'];
        $paymentFailUrl     = $app->settings['payment.fail.url'];
        $paymentCancelUrl   = $app->settings['payment.cancel.url'];

        $gmoShopId        = $app->settings['gmopg.shopid'];
        $gmoOrderRef      = str_replace('.', '-', $orderRef);
        $gmoPassword      = $app->settings['gmopg.password'];
        $gmoEntryUrl      = $app->settings['gmopg.entry.url'];
        $gmoResultUrl     = $app->settings['gmopg.result.url'];
        $gmoDatetime      = date('YmdHis');
        $gmoShopPass      = md5($gmoShopId . '|' . $gmoOrderRef . '|' . sprintf('%.2f', $paymentAmount) . '||' . 'USD' . '|' . $gmoPassword . '|' . $gmoDatetime);
        $gmoShopPassYouth = md5($gmoShopId . '|' . $gmoOrderRef . '|' . sprintf('%.2f', $paymentAmountYouth) . '||' . 'USD' . '|' . $gmoPassword . '|' . $gmoDatetime);

        // 為替レート
        $usdjpy   = $app->settings['usdjpy'];
        $rateDate = $app->settings['rate.date'];

        // 写真の枚数に関連した数値を取得する。
        $picturePackage   = $app->settings['picture.package'];
        $picturePurchased = PaymentService::getPicturePurchased($memberRegistNo);
        $pictureEntered   = $entries['total'];

        // 開催期間か判定する。
        $termStart    = SettingService::getTermStart();
        $termEnd      = SettingService::getTermEnd();
        $termTimezone = SettingService::getTermTimezone();
        $inTerm       = SettingService::inTerm($termStart, $termEnd, $termTimezone);

        // 支払い期間か判定する。
        $payStart    = SettingService::getPayStart();
        $payEnd      = SettingService::getPayEnd();
        $payTimezone = SettingService::getPayTimezone();
        $inPay       = SettingService::inTerm($payStart, $payEnd, $payTimezone);

        // if ($memberRegistNo == 90) { // Shinichi Morita (Developer)
        //     $inTerm = true;
        //     $inPay  = true;
        // }

        $app->render(
            TemplateService::getTemplatePath('member/home.php'),
            [
                'app' => $app,

                'usePaydollar' => $app->config('use.paydollar'),
                'usePaypal'    => $app->config('use.paypal'),
                'useGmoPg'     => $app->config('use.gmopg'),

                'usdjpy'   => $usdjpy,
                'rateDate' => $rateDate,

                'inTerm' => $inTerm,
                'inPay'  => $inPay,

                'name' => $name,
                'mail' => $mail,

                'status'   => $status,
                'orderRef' => $orderRef,

                'paymentEndpoint'    => $paymentEndpoint,
                'paymentMerchantId'  => $paymentMerchantId,
                'paymentCurrency'    => $paymentCurrency,
                'paymentAmount'      => sprintf('%.2f', $paymentAmount),
                'paymentAmountYouth' => sprintf('%.2f', $paymentAmountYouth),
                'paymentSuccessUrl'  => $paymentSuccessUrl,
                'paymentFailUrl'     => $paymentFailUrl,
                'paymentCancelUrl'   => $paymentCancelUrl,

                'gmoShopId'        => $gmoShopId,
                'gmoOrderRef'      => $gmoOrderRef,
                'gmoDatetime'      => $gmoDatetime,
                'gmoShopPass'      => $gmoShopPass,
                'gmoShopPassYouth' => $gmoShopPassYouth,
                'gmoEntryUrl'      => $gmoEntryUrl,
                'gmoResultUrl'     => $gmoResultUrl,

                'picturePackage'   => $picturePackage,
                'picturePurchased' => $picturePurchased,
                'pictureEntered'   => $pictureEntered,
            ]
        );
    }

    /**
     * サインオフする.
     *
     * GET /member/signoff
     */
    public static function signoff($app)
    {
        CookieService::invalidateMemberRegistNo();
        SessionService::invalidateMemberRegistNo();

        $app->member = null;

        $app->redirect('/user/member/logon');
    }

    /**
     * パスワード忘れフォームを表示する.
     *
     * GET /member/forgot
     */
    public static function forgot($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/forgot.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * パスワード再設定メールを送信する.
     *
     * POST /member/forgot
     */
    public static function forgotProcess($app)
    {
        $back = $app->request->post('back');
        if ($back) {
            $app->redirect('/user/member/logon');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            $mail = $app->request->post('mail');

            // validation
            $errors = [];
            if ($error = vs::validateEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            if (!empty($errors)) {
                $app->flash('error', $errors);
                $app->redirect('/user/member/forgot');
            }

            $member = MemberService::getMemberByMail($mail);
            if ($member) {
                // send a mail
                $t   = time();
                $mid = MemberService::encryptString($member->member_regist_no, $t);
                MailService::sendForgotMail($mail, $mid, $t);
                $app->redirect('/user/member/forgot/complete');
            } else {
                $app->flash('error', [Message::getMessage(Message::MSG_THIS_EMAIL_ADDRESS_COULD_NOT_FOUND)]);
                $app->redirect('/user/member/forgot');
            }
        }
    }

    /**
     * パスワード再設定メール送信完了画面を表示する.
     *
     * GET /member/forgot/complete
     */
    public static function forgotComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/forgot_complete.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * パスワード再設定画面を表示する.
     *
     * GET /member/resetpassword
     */
    public static function resetpassword($app)
    {
        $mid = $app->request->get('mid');
        $t   = $app->request->get('t');

        $errors = [];
        if (isset($mid) && isset($t)) {
            $encrypted      = rawurldecode($mid);
            $memberRegistNo = MemberService::decryptString($encrypted, $t);
            $member         = MemberService::getMemberByMemberRegistNo($memberRegistNo);
            if (!$member) {
                $errors[] = Message::getMessage(Message::MSG_INVALID_URL);
            }
        } else {
            $errors[] = Message::getMessage(Message::MSG_INVALID_URL);
        }
        $app->flash('error', $errors);
        $app->render(
            TemplateService::getTemplatePath('member/resetpassword.php'),
            [
                'app' => $app,
                'mid' => rawurlencode($mid),
                't'   => $t,
            ]
        );
    }

    /**
     * パスワードを再設定する.
     *
     * POST /member/resetpassword
     */
    public static function resetpasswordProcess($app)
    {
        $back = $app->request->post('back');
        if ($back) {
            $app->redirect('/user/member/logon');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            $password     = $app->request->post('password');
            $password_chk = $app->request->post('password_chk');

            // validation
            $errors = [];
            if ($error = vs::validatePassword($password)) {
                $errors = array_merge($errors, $error);
            }
            if ($error = vs::validateRePassword($password_chk)) {
                $errors = array_merge($errors, $error);
            }

            // password, password_chk
            if (empty($errors)) {
                if (strcmp($password, $password_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK);
                }
            }

            $mid = $app->request->post('mid');
            $t   = $app->request->post('t');
            if (empty($errors)) {
                if (isset($mid) && isset($t)) {
                    $encrypted      = rawurldecode($mid);
                    $memberRegistNo = MemberService::decryptString($encrypted, $t);
                    if (MemberService::updateMemberPassword($memberRegistNo, $password)) {
                        $app->redirect('/user/member/resetpassword/complete');
                    }
                }
                $errors[] = Message::getMessage(Message::MSG_INVALID_URL);
                $app->flash('error', $errors);
                $app->redirect("/user/member/resetpassword?mid={$mid}&t={$t}");
            } else {
                $app->flash('error', $errors);
                $app->redirect("/user/member/resetpassword?mid={$mid}&t={$t}");
            }
        } else {
            $app->redirect('/user/member/logon');
        }
    }

    /**
     * パスワード再設定完了画面を表示する.
     */
    public static function resetpasswordComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/resetpassword_complete.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * サインアップ画面を表示する.
     * セッションに入力値が格納されている場合はそれを表示する.
     *
     * GET /member/signup
     */
    public static function signup($app)
    {
        // セッションから入力値を取得する。
        $mail         = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
        $mail_chk     = isset($_SESSION['mail_chk']) ? $_SESSION['mail_chk'] : '';
        $name_l       = isset($_SESSION['name_l']) ? $_SESSION['name_l'] : '';
        $name_f       = isset($_SESSION['name_f']) ? $_SESSION['name_f'] : '';
        $zipcode      = isset($_SESSION['zipcode']) ? $_SESSION['zipcode'] : '';
        $country      = isset($_SESSION['country']) ? $_SESSION['country'] : '';
        $addr         = isset($_SESSION['addr']) ? $_SESSION['addr'] : '';
        $tel          = isset($_SESSION['tel']) ? $_SESSION['tel'] : '';
        $mb_tel       = isset($_SESSION['mb_tel']) ? $_SESSION['mb_tel'] : '';
        $password     = isset($_SESSION['password']) ? $_SESSION['password'] : '';
        $password_chk = isset($_SESSION['password_chk']) ? $_SESSION['password_chk'] : '';
        $gender       = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
        $enquete      = isset($_SESSION['enquete']) ? $_SESSION['enquete'] : [];
        $promo_code   = isset($_SESSION['promo_code']) ? $_SESSION['promo_code'] : CookieService::getCampaign() ? CookieService::getCampaign() : $app->request->get('campaign');

        CookieService::setCampaign($promo_code);

        $app->render(
            TemplateService::getTemplatePath('member/signup.php'),
            [
                'app' => $app,

                'countries' => Country::$countries,
                'enquetes'  => Enquete::getEnquetes(),

                'mail'         => $mail,
                'mail_chk'     => $mail_chk,
                'name_l'       => $name_l,
                'name_f'       => $name_f,
                'zipcode'      => $zipcode,
                'country'      => $country,
                'addr'         => $addr,
                'tel'          => $tel,
                'mb_tel'       => $mb_tel,
                'password'     => $password,
                'password_chk' => $password_chk,
                'gender'       => $gender,
                'enquete'      => $enquete,

                'promo_code' => $promo_code,
            ]
        );
    }

    /**
     * サインアップ確認画面を表示する.
     *
     * POST /member/signup
     */
    public static function signupConfirmation($app)
    {
        $back = $app->request->post('back');
        if ($back) {
            // unset session
            unset($_SESSION['mail']);
            unset($_SESSION['mail_chk']);
            unset($_SESSION['name_l']);
            unset($_SESSION['name_f']);
            unset($_SESSION['zipcode']);
            unset($_SESSION['country']);
            unset($_SESSION['addr']);
            unset($_SESSION['tel']);
            unset($_SESSION['mb_tel']);
            unset($_SESSION['password']);
            unset($_SESSION['password_chk']);
            unset($_SESSION['gender']);
            unset($_SESSION['enquete']);
            unset($_SESSION['promo_code']);

            $app->redirect('/user/member/logon');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            // get values from the form
            $mail         = $app->request->post('mail');
            $mail_chk     = $app->request->post('mail_chk');
            $name_l       = $app->request->post('name_l');
            $name_f       = $app->request->post('name_f');
            $zipcode      = $app->request->post('zipcode');
            $country      = $app->request->post('country');
            $addr         = $app->request->post('addr');
            $tel          = $app->request->post('tel');
            $mb_tel       = $app->request->post('mb_tel');
            $password     = $app->request->post('password');
            $password_chk = $app->request->post('password_chk');
            $gender       = $app->request->post('gender');
            $enquete      = $app->request->post('enquete');

            $enquete = isset($enquete) ? $enquete : [];

            $promo_code = $app->request->post('promo_code');

            $agreement = $app->request->post('agreement');
            $agreement = isset($agreement) ? true : false;

            // validation
            $errors = [];
            if ($agreement) {
                // mail
                if ($error = vs::validateEmail($mail)) {
                    $errors = array_merge($errors, $error);
                }
                // mail_chk
                if ($error = vs::validateReEmail($mail_chk)) {
                    $errors = array_merge($errors, $error);
                }
                // name_l
                if ($error = vs::validateLastName($name_l)) {
                    $errors = array_merge($errors, $error);
                }
                // name_f
                if ($error = vs::validateFirstName($name_f)) {
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
                // addr
                if ($error = vs::validateAddress($addr)) {
                    $errors = array_merge($errors, $error);
                }
                // tel
                if ($error = vs::validateTelephone($tel)) {
                    $errors = array_merge($errors, $error);
                }
                // mb_tel
                if ($error = vs::validateMobile($mb_tel)) {
                    $errors = array_merge($errors, $error);
                }
                // password
                if ($error = vs::validatePassword($password)) {
                    $errors = array_merge($errors, $error);
                }
                // re-enter password
                if ($error = vs::validateRePassword($password_chk)) {
                    $errors = array_merge($errors, $error);
                }
                // gender
                if ($error = vs::validateGender($gender)) {
                    $errors = array_merge($errors, $error);
                }

                if (empty($errors)) {
                    // mail, mail_chk
                    if (strcmp($mail, $mail_chk) !== 0) {
                        $errors[] = Message::getMessage(Message::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK);
                    }
                    // password, password_chk
                    if (strcmp($password, $password_chk) !== 0) {
                        $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK);
                    }
                }
                // enquete
                /*
                if (empty($enquete)) {
                    $errors[] = Message::getMessage(Message::MSG_PLEASE_CHECK_HOW_DID_YOU_FIND_US);
                }
                 */

                // check duplicate mail address
                if ($mail) {
                    $memberDup = MemberService::getMemberByMail($mail);
                    if ($memberDup) {
                        $errors[] = Message::getMessage(Message::MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED);
                    }
                }
            } else {
                $errors[] = Message::getMessage(Message::MSG_PLEASE_AGREE_TO_THE_TERMS_AND_CONDITIONS);
            }

            // save values to the session
            $_SESSION['mail']         = $mail;
            $_SESSION['mail_chk']     = $mail_chk;
            $_SESSION['name_l']       = $name_l;
            $_SESSION['name_f']       = $name_f;
            $_SESSION['zipcode']      = $zipcode;
            $_SESSION['country']      = $country;
            $_SESSION['addr']         = $addr;
            $_SESSION['tel']          = $tel;
            $_SESSION['mb_tel']       = $mb_tel;
            $_SESSION['password']     = $password;
            $_SESSION['password_chk'] = $password_chk;
            $_SESSION['gender']       = $gender;
            $_SESSION['enquete']      = $enquete;
            $_SESSION['promo_code']   = $promo_code;

            if (empty($errors)) {
                $app->render(
                    TemplateService::getTemplatePath('member/signup_confirm.php'),
                    [
                        'app' => $app,

                        'countries' => Country::$countries,
                        'enquetes'  => Enquete::getEnquetes(),

                        'mail'         => $mail,
                        'mail_chk'     => $mail_chk,
                        'name_l'       => $name_l,
                        'name_f'       => $name_f,
                        'zipcode'      => $zipcode,
                        'country'      => $country,
                        'addr'         => $addr,
                        'tel'          => $tel,
                        'mb_tel'       => $mb_tel,
                        'password'     => $password,
                        'password_chk' => $password_chk,
                        'gender'       => $gender,
                        'enquete'      => $enquete,

                        'promo_code' => $promo_code,
                    ]
                );
            } else {
                $app->flash('error', $errors);
                $app->redirect('/user/member/signup');
            }
        } else {
            $app->redirect('/user/member/logon');
        }
    }

    /**
     * サインアップ処理.
     * 入力されたデータをデータベースに登録する.
     *
     * PUT /member/signup
     */
    public static function signupProcess($app)
    {
        $back = $app->request->put('back');
        if ($back) {
            $app->redirect('/user/member/signup');
        }

        $send = $app->request->put('send');
        if ($send) {
            // セッションから入力値を取得する。
            $mail         = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
            $mail_chk     = isset($_SESSION['mail_chk']) ? $_SESSION['mail_chk'] : '';
            $name_l       = isset($_SESSION['name_l']) ? $_SESSION['name_l'] : '';
            $name_f       = isset($_SESSION['name_f']) ? $_SESSION['name_f'] : '';
            $zipcode      = isset($_SESSION['zipcode']) ? $_SESSION['zipcode'] : '';
            $country      = isset($_SESSION['country']) ? $_SESSION['country'] : '';
            $addr         = isset($_SESSION['addr']) ? $_SESSION['addr'] : '';
            $tel          = isset($_SESSION['tel']) ? $_SESSION['tel'] : '';
            $mb_tel       = isset($_SESSION['mb_tel']) ? $_SESSION['mb_tel'] : '';
            $password     = isset($_SESSION['password']) ? $_SESSION['password'] : '';
            $password_chk = isset($_SESSION['password_chk']) ? $_SESSION['password_chk'] : '';
            $gender       = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
            $enquete      = isset($_SESSION['enquete']) ? $_SESSION['enquete'] : [];
            $promo_code   = isset($_SESSION['promo_code']) ? $_SESSION['promo_code'] : '';

            // validation
            $errors = [];
            // mail
            if ($error = vs::validateEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // mail_chk
            if ($error = vs::validateReEmail($mail_chk)) {
                $errors = array_merge($errors, $error);
            }
            // name_l
            if ($error = vs::validateLastName($name_l)) {
                $errors = array_merge($errors, $error);
            }
            // name_f
            if ($error = vs::validateFirstName($name_f)) {
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
            // addr
            if ($error = vs::validateAddress($addr)) {
                $errors = array_merge($errors, $error);
            }
            // tel
            if ($error = vs::validateTelephone($tel)) {
                $errors = array_merge($errors, $error);
            }
            // mb_tel
            if ($error = vs::validateMobile($mb_tel)) {
                $errors = array_merge($errors, $error);
            }
            // password
            if ($error = vs::validatePassword($password)) {
                $errors = array_merge($errors, $error);
            }
            // re-enter password
            if ($error = vs::validateRePassword($password_chk)) {
                $errors = array_merge($errors, $error);
            }
            // gender
            if ($error = vs::validateGender($gender)) {
                $errors = array_merge($errors, $error);
            }

            if (empty($errors)) {
                // mail, mail_chk
                if (strcmp($mail, $mail_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK);
                }
                // password, password_chk
                if (strcmp($password, $password_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK);
                }
            }

            // check duplicate mail address
            if ($mail) {
                $memberDup = MemberService::getMemberByMail($mail);
                if ($memberDup) {
                    $errors[] = Message::getMessage(Message::MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED);
                }
            }

            if (empty($errors)) {
                // save to database
                $remoteAddr = $_SERVER['REMOTE_ADDR'];
                $complete   = 0;
                $status     = 2;

                $member = MemberService::newMember(
                    $remoteAddr,
                    $mail,
                    $name_l,
                    $name_f,
                    $zipcode,
                    $country,
                    $addr,
                    $tel,
                    $mb_tel,
                    $password,
                    $gender,
                    $complete,
                    $enquete,
                    $status,
                    $promo_code
                );

                // send a mail
                if ($member) {
                    $t    = time();
                    $mid  = MemberService::encryptString($member->member_regist_no, $t);
                    $name = $name_f . ' ' . $name_l;
                    MailService::sendPreRegisteringMail($name, $mail, $mid, $t);
                }

                // unset session
                unset($_SESSION['mail']);
                unset($_SESSION['mail_chk']);
                unset($_SESSION['name_l']);
                unset($_SESSION['name_f']);
                unset($_SESSION['zipcode']);
                unset($_SESSION['country']);
                unset($_SESSION['addr']);
                unset($_SESSION['tel']);
                unset($_SESSION['mb_tel']);
                unset($_SESSION['password']);
                unset($_SESSION['password_chk']);
                unset($_SESSION['gender']);
                unset($_SESSION['enquete']);
                unset($_SESSION['promo_code']);

                CookieService::invalidateCampaign();

                $app->redirect('/user/member/signup/complete');
            } else {
                $app->flash('error', $errors);
                $app->redirect('/user/member/signup');
            }
        }
    }

    /**
     * 仮登録完了画面を表示する.
     */
    public static function signupComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/signup_complete.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * メールアドレス確認画面を表示する.
     * 仮登録後に送信したメールから呼び出される.
     *
     * GET /member/verification
     */
    public static function verification($app)
    {
        $mid = $app->request->get('mid');
        $t   = $app->request->get('t');

        $message = Message::getMessage(Message::MSG_INVALID_URL);
        if (isset($mid) && isset($t)) {
            $encrypted      = rawurldecode($mid);
            $memberRegistNo = MemberService::decryptString($encrypted, $t);
            // 登録を完了する。
            $member = MemberService::finishMember($memberRegistNo);
            if ($member) {
                // send a mail
                $name = $member->name_m . ' ' . $member->name_s;
                $mail = $member->mail;
                MailService::sendRegisteringMail($name, $mail);

                $message = Message::getMessage(Message::MSG_YOUR_REGISTRATION_IS_COMPLETED);
            }
        }

        $app->flash('message', $message);
        $app->redirect('/user/member/verification/complete');
    }

    /**
     * メールアドレス確認完了画面を表示する.
     */
    public static function verificationComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/signup_verified.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * メンバー編集画面を表示する.
     *
     * GET /member/edit
     */
    public static function edit($app)
    {
        $member = $app->member;

        $enquete = isset($member->enquete1) ? explode(',', $member->enquete1) : [];

        $mail         = isset($_SESSION['mail']) ? $_SESSION['mail'] : $member->mail;
        $mail_chk     = isset($_SESSION['mail_chk']) ? $_SESSION['mail_chk'] : $member->mail;
        $name_l       = isset($_SESSION['name_l']) ? $_SESSION['name_l'] : $member->name_s;
        $name_f       = isset($_SESSION['name_f']) ? $_SESSION['name_f'] : $member->name_m;
        $zipcode      = isset($_SESSION['zipcode']) ? $_SESSION['zipcode'] : $member->zipcode1;
        $country      = isset($_SESSION['country']) ? $_SESSION['country'] : $member->pref;
        $addr         = isset($_SESSION['addr']) ? $_SESSION['addr'] : $member->apname;
        $tel          = isset($_SESSION['tel']) ? $_SESSION['tel'] : $member->tel;
        $mb_tel       = isset($_SESSION['mb_tel']) ? $_SESSION['mb_tel'] : $member->mb_tel;
        $password     = isset($_SESSION['password']) ? $_SESSION['password'] : '';
        $password_chk = isset($_SESSION['password_chk']) ? $_SESSION['password_chk'] : '';
        $gender       = isset($_SESSION['gender']) ? $_SESSION['gender'] : $member->sex;
        $enquete      = isset($_SESSION['enquete']) ? $_SESSION['enquete'] : $enquete;

        $app->render(
            TemplateService::getTemplatePath('member/edit.php'),
            [
                'app' => $app,

                'countries' => Country::$countries,
                'enquetes'  => Enquete::getEnquetes(),

                'mail'         => $mail,
                'mail_chk'     => $mail_chk,
                'name_l'       => $name_l,
                'name_f'       => $name_f,
                'zipcode'      => $zipcode,
                'country'      => $country,
                'addr'         => $addr,
                'tel'          => $tel,
                'mb_tel'       => $mb_tel,
                'password'     => $password,
                'password_chk' => $password_chk,
                'gender'       => $gender,
                'enquete'      => $enquete,
            ]
        );
    }

    /**
     * メンバー編集確認画面を表示する.
     *
     * POST /member/edit
     */
    public static function editConfirmation($app)
    {
        $back = $app->request->post('back');
        if ($back) {
            // unset session
            unset($_SESSION['mail']);
            unset($_SESSION['mail_chk']);
            unset($_SESSION['name_l']);
            unset($_SESSION['name_f']);
            unset($_SESSION['zipcode']);
            unset($_SESSION['country']);
            unset($_SESSION['addr']);
            unset($_SESSION['tel']);
            unset($_SESSION['mb_tel']);
            unset($_SESSION['password']);
            unset($_SESSION['password_chk']);
            unset($_SESSION['gender']);
            unset($_SESSION['enquete']);

            $app->redirect('/user/member/home');
        }

        $confirmation = $app->request->post('confirmation');
        if ($confirmation) {
            // get values from the form
            $mail         = $app->request->post('mail');
            $mail_chk     = $app->request->post('mail_chk');
            $name_l       = $app->request->post('name_l');
            $name_f       = $app->request->post('name_f');
            $zipcode      = $app->request->post('zipcode');
            $country      = $app->request->post('country');
            $addr         = $app->request->post('addr');
            $tel          = $app->request->post('tel');
            $mb_tel       = $app->request->post('mb_tel');
            $password     = $app->request->post('password');
            $password_chk = $app->request->post('password_chk');
            $gender       = $app->request->post('gender');
            $enquete      = $app->request->post('enquete');

            $enquete = isset($enquete) ? $enquete : [];

            // validation
            $errors = [];
            // mail
            if ($error = vs::validateEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // mail_chk
            if ($error = vs::validateReEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // name_l
            if ($error = vs::validateLastName($name_l)) {
                $errors = array_merge($errors, $error);
            }
            // name_f
            if ($error = vs::validateFirstName($name_f)) {
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
            // addr
            if ($error = vs::validateAddress($addr)) {
                $errors = array_merge($errors, $error);
            }
            // tel
            if ($error = vs::validateTelephone($tel)) {
                $errors = array_merge($errors, $error);
            }
            // mb_tel
            if ($error = vs::validateMobile($mb_tel)) {
                $errors = array_merge($errors, $error);
            }
            // password (not necessary)
            if ($error = vs::validatePasswordNotNecessary($password)) {
                $errors = array_merge($errors, $error);
            }
            // password_chk (not necessary)
            if ($error = vs::validateRePasswordNotNecessary($password_chk)) {
                $errors = array_merge($errors, $error);
            }
            // gender
            if ($error = vs::validateGender($gender)) {
                $errors = array_merge($errors, $error);
            }

            if (empty($errors)) {
                // mail, mail_chk
                if (strcmp($mail, $mail_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK);
                }
                // password, password_chk
                if (strcmp($password, $password_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK);
                }
            }
            // enquete
            /*
            if (empty($enquete)) {
                $errors[] = Message::getMessage(Message::MSG_PLEASE_CHECK_HOW_DID_YOU_FIND_US);
            }
             */

            // check duplicate mail address
            $member = MemberService::getMemberByMail($mail);
            if ($member && $member->member_regist_no !== $app->member->member_regist_no) {
                $errors[] = Message::getMessage(Message::MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED);
            }

            // save values to the session
            $_SESSION['mail']         = $mail;
            $_SESSION['mail_chk']     = $mail_chk;
            $_SESSION['name_l']       = $name_l;
            $_SESSION['name_f']       = $name_f;
            $_SESSION['zipcode']      = $zipcode;
            $_SESSION['country']      = $country;
            $_SESSION['addr']         = $addr;
            $_SESSION['tel']          = $tel;
            $_SESSION['mb_tel']       = $mb_tel;
            $_SESSION['password']     = $password;
            $_SESSION['password_chk'] = $password_chk;
            $_SESSION['gender']       = $gender;
            $_SESSION['enquete']      = $enquete;

            if (empty($errors)) {
                $app->render(
                    TemplateService::getTemplatePath('member/edit_confirm.php'),
                    [
                        'app' => $app,

                        'countries' => Country::$countries,
                        'enquetes'  => Enquete::getEnquetes(),

                        'mail'         => $mail,
                        'mail_chk'     => $mail_chk,
                        'name_l'       => $name_l,
                        'name_f'       => $name_f,
                        'zipcode'      => $zipcode,
                        'country'      => $country,
                        'addr'         => $addr,
                        'tel'          => $tel,
                        'mb_tel'       => $mb_tel,
                        'password'     => $password,
                        'password_chk' => $password_chk,
                        'gender'       => $gender,
                        'enquete'      => $enquete,
                    ]
                );
            } else {
                $app->flash('error', $errors);
                $app->redirect('/user/member/edit');
            }
        } else {
            $app->redirect('/user/member/logon');
        }
    }

    /**
     * メンバー編集処理.
     *
     * PUT /member/edit
     */
    public static function editProcess($app)
    {
        $back = $app->request->put('back');
        if ($back) {
            $app->redirect('/user/member/edit');
        }

        $update = $app->request->put('update');
        if ($update) {
            $mail         = $_SESSION['mail'];
            $mail_chk     = $_SESSION['mail_chk'];
            $name_l       = $_SESSION['name_l'];
            $name_f       = $_SESSION['name_f'];
            $zipcode      = $_SESSION['zipcode'];
            $country      = $_SESSION['country'];
            $addr         = $_SESSION['addr'];
            $tel          = $_SESSION['tel'];
            $mb_tel       = $_SESSION['mb_tel'];
            $password     = $_SESSION['password'];
            $password_chk = $_SESSION['password_chk'];
            $gender       = $_SESSION['gender'];
            $enquete      = $_SESSION['enquete'];

            // validation
            $errors = [];
            // mail
            if ($error = vs::validateEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // mail_chk
            if ($error = vs::validateReEmail($mail)) {
                $errors = array_merge($errors, $error);
            }
            // name_l
            if ($error = vs::validateLastName($name_l)) {
                $errors = array_merge($errors, $error);
            }
            // name_f
            if ($error = vs::validateFirstName($name_f)) {
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
            // addr
            if ($error = vs::validateAddress($addr)) {
                $errors = array_merge($errors, $error);
            }
            // tel
            if ($error = vs::validateTelephone($tel)) {
                $errors = array_merge($errors, $error);
            }
            // mb_tel
            if ($error = vs::validateMobile($mb_tel)) {
                $errors = array_merge($errors, $error);
            }
            // password (not necessary)
            if ($error = vs::validatePasswordNotNecessary($password)) {
                $errors = array_merge($errors, $error);
            }
            // password_chk (not necessary)
            if ($error = vs::validateRePasswordNotNecessary($password_chk)) {
                $errors = array_merge($errors, $error);
            }
            // gender
            if ($error = vs::validateGender($gender)) {
                $errors = array_merge($errors, $error);
            }

            if (empty($errors)) {
                // mail, mail_chk
                if (strcmp($mail, $mail_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK);
                }
                // password, password_chk
                if (strcmp($password, $password_chk) !== 0) {
                    $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK);
                }
            }
            // enquete
            /*
            if (empty($enquete)) {
                $errors[] = Message::getMessage(Message::MSG_PLEASE_CHECK_HOW_DID_YOU_FIND_US);
            }
             */

            // check duplicate mail address
            $member = MemberService::getMemberByMail($mail);
            if ($member && $member->member_regist_no !== $app->member->member_regist_no) {
                $errors[] = Message::getMessage(Message::MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED);
            }

            if (empty($errors)) {
                // save to database
                $remoteAddr = $_SERVER['REMOTE_ADDR'];

                $member = MemberService::updateMember(
                    $app->member->member_regist_no,
                    $remoteAddr,
                    $mail,
                    $name_l,
                    $name_f,
                    $zipcode,
                    $country,
                    $addr,
                    $tel,
                    $mb_tel,
                    $password,
                    $gender,
                    $enquete
                );

                // unset session
                unset($_SESSION['mail']);
                unset($_SESSION['mail_chk']);
                unset($_SESSION['name_l']);
                unset($_SESSION['name_f']);
                unset($_SESSION['zipcode']);
                unset($_SESSION['country']);
                unset($_SESSION['addr']);
                unset($_SESSION['tel']);
                unset($_SESSION['mb_tel']);
                unset($_SESSION['password']);
                unset($_SESSION['password_chk']);
                unset($_SESSION['gender']);
                unset($_SESSION['enquete']);

                $app->redirect('/user/member/edit/complete');
            } else {
                $app->flash('error', $errors);
                $app->redirect('/user/member/edit');
            }
        }
    }

    /**
     * メンバー編集完了画面を表示する.
     *
     * GET /member/edit/complete
     */
    public static function editComplete($app)
    {
        $app->render(
            TemplateService::getTemplatePath('member/edit_complete.php'),
            [
                'app' => $app,
            ]
        );
    }

    /**
     * メンバーを全員削除する.
     */
    public static function cleanup($app)
    {
        MemberService::cleanup();
    }
}
