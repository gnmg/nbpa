<?php

/**
 * @version SVN: $Id: Message.php 163 2015-09-08 06:01:23Z morita $
 */
namespace NBPA\Models;

class Message
{
    const MSG_NO_PHOTO_YOU_CAN_ENTRY                   = 1;
    const MSG_EMAIL_ADDRESS_OR_PASSWORD_IS_NOT_CORRECT = 2;
    const MSG_PERIOD_HAS_ENDED                         = 3;

    const MSG_NO_FILE_UPLOADED               = 10;
    const MSG_FILE_UPLOAD_ERROR              = 11;
    const MSG_PLEASE_AGREE_TO_THE_CONDITIONS = 12;
    const MSG_PLEASE_ENTER_THE_TITLE         = 13;
    const MSG_THE_TITLE_IS_NOT_CORRECT       = 14;
    const MSG_PLEASE_ENTER_EMBEDCODE         = 15;

    const MSG_INVALID_URL                        = 20;
    const MSG_THIS_EMAIL_ADDRESS_COULD_NOT_FOUND = 21;

    const MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK    = 30;
    const MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK         = 31;
    const MSG_PLEASE_CHECK_HOW_DID_YOU_FIND_US         = 32;
    const MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED  = 33;
    const MSG_PLEASE_AGREE_TO_THE_TERMS_AND_CONDITIONS = 34;
    const MSG_YOUR_REGISTRATION_IS_COMPLETED           = 35;

    const MSG_PLEASE_ENTER_EMAIL_ADDRESS                   = 110;
    const MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT            = 111;
    const MSG_PLEASE_RE_ENTER_EMAIL_ADDRESS                = 120;
    const MSG_YOUR_RE_ENTERED_EMAIL_ADDRESS_IS_NOT_CORRECT = 121;
    const MSG_PLEASE_ENTER_PASSWORD                        = 130;
    const MSG_YOUR_PASSWORD_IS_NOT_CORRECT                 = 131;
    const MSG_PLEASE_RE_ENTER_PASSWORD                     = 140;
    const MSG_YOUR_RE_ENTERED_PASSWORD_IS_NOT_CORRECT      = 141;
    const MSG_PLEASE_ENTER_YOUR_LAST_NAME                  = 150;
    const MSG_YOUR_LAST_NAME_IS_NOT_CORRECT                = 151;
    const MSG_PLEASE_ENTER_YOUR_FIRST_NAME                 = 160;
    const MSG_YOUR_FIRST_NAME_IS_NOT_CORRECT               = 161;
    const MSG_PLEASE_ENTER_YOUR_POSTAL_CODE                = 170;
    const MSG_YOUR_POSTAL_CODE_IS_NOT_CORRECT              = 171;
    const MSG_PLEASE_CHOOSE_THE_COUNTRY                    = 180;
    const MSG_YOUR_CHOOSED_COUNTRY_IS_NOT_CORRECT          = 181;
    const MSG_PLEASE_ENTER_YOUR_ADDRESS                    = 190;
    const MSG_YOUR_ADDRESS_IS_NOT_CORRECT                  = 191;
    const MSG_PLEASE_ENTER_TELEPHONE_NUMBER                = 200;
    const MSG_YOUR_TELEPHONE_NUMBER_IS_NOT_CORRECT         = 201;
    const MSG_PLEASE_ENTER_MOBILE_NUMBER                   = 210;
    const MSG_YOUR_MOBILE_NUMBER_IS_NOT_CORRECT            = 211;
    const MSG_PLEASE_CHOOSE_YOUR_GENDER                    = 220;
    const MSG_YOUR_CHOOSED_GENDER_IS_NOT_CORRECT           = 221;

    private static $messages = [
        self::MSG_NO_PHOTO_YOU_CAN_ENTRY => [
            'en' => 'Please complete payment below before entering pictures.',
            'ja' => '下記よりお支払いを先にお願いします。',
            'ko' => '사진을 엔트리할 수 없습니다.',
            'sc' => '照片不能通过。',
            'tc' => '照片不能通過。',
        ],
        self::MSG_EMAIL_ADDRESS_OR_PASSWORD_IS_NOT_CORRECT => [
            'en' => 'Your e-mail address or password is not correct.',
            'ja' => 'メールアドレスまたはパスワードが間違っています。',
            'ko' => '메일 주소 또는 비밀번호가 잘못되었습니다.',
            'sc' => '电子邮箱地址或密码不正确。',
            'tc' => 'E-mail地址或密碼不正確。',
        ],
        self::MSG_PERIOD_HAS_ENDED => [
            'en' => 'Period for entry has ended.',
            'ja' => '受付期間が終了しました。',
            'ko' => 'Period for entry has ended.',
            'sc' => 'Period for entry has ended.',
            'tc' => 'Period for entry has ended.',
        ],
        self::MSG_NO_FILE_UPLOADED => [
            'en' => 'No file uploaded.',
            'ja' => '写真をアップロード出来ませんでした。',
            'ko' => '사진을 업로드할 수 없었습니다.',
            'sc' => '照片没有上传。',
            'tc' => '照片沒有上傳。',
        ],
        self::MSG_FILE_UPLOAD_ERROR => [
            'en' => 'File upload error.',
            'ja' => '写真のアップロードに失敗しました。',
            'ko' => '사진 업로드에 실패했습니다.',
            'sc' => '照片的上传失败。',
            'tc' => '照片的上傳失敗。',
        ],
        self::MSG_PLEASE_AGREE_TO_THE_CONDITIONS => [
            'en' => 'Please agree to out contest guidelines.',
            'ja' => '応募規約に同意して下さい。',
            'ko' => '응모규약에 동의해 주세요.',
            'sc' => '请同意参加规约。',
            'tc' => '請同意參加規約。',
        ],
        self::MSG_PLEASE_ENTER_THE_TITLE => [
            'en' => 'Please enter the title.',
            'ja' => 'タイトルを入力して下さい。',
            'ko' => '타이틀을 입력해 주세요.',
            'sc' => '请输入作品题目。',
            'tc' => '請輸入作品題目。',
        ],
        self::MSG_PLEASE_ENTER_EMBEDCODE => [
            'en' => 'Please enter the embed code.',
            'ja' => 'Please enter the embed code.',
            'ko' => 'Please enter the embed code.',
            'sc' => 'Please enter the embed code.',
            'tc' => 'Please enter the embed code.',
        ],
        self::MSG_THE_TITLE_IS_NOT_CORRECT => [
            'en' => 'Your title is too long. It needs to be under 80 characters.',
            'ja' => 'タイトルに誤りがあります。',
            'ko' => '타이틀이 잘못되었습니다.',
            'sc' => '输入的作品题目有错误。',
            'tc' => '輸入的作品題目有錯誤。',
        ],
        self::MSG_INVALID_URL => [
            'en' => 'Invalid URL.',
            'ja' => '無効なURLです。',
            'ko' => '무효인 URL입니다.',
            'sc' => '无效URL。',
            'tc' => '無效ULR。',
        ],
        self::MSG_THIS_EMAIL_ADDRESS_COULD_NOT_FOUND => [
            'en' => 'This e-mail address could not found.',
            'ja' => 'そのメールアドレスは登録されていません。',
            'ko' => 'This e-mail address could not found.',
            'sc' => 'This e-mail address could not found.',
            'tc' => 'This e-mail address could not found.',
        ],
        self::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT_CHK => [
            'en' => 'Your e-mail address and re-entered address does not match.',
            'ja' => 'メールアドレスとメールアドレス(確認)とが一致しません。',
            'ko' => '메일 주소와 메일 주소(확인)가 일치하지 않습니다.',
            'sc' => '电子邮箱地址和确认电子邮箱地址不一致。',
            'tc' => 'E-mail地址和確認E-mail地址不一致。',
        ],
        self::MSG_YOUR_PASSWORD_IS_NOT_CORRECT_CHK => [
            'en' => 'Your password and re-entered password does not match.',
            'ja' => 'パスワードとパスワード(確認)とが一致しません。',
            'ko' => '비밀번호와 비밀번호(확인)가 일치하지 않습니다.',
            'sc' => '密码和確認密码不一致。',
            'tc' => '密碼和確認密碼不一致',
        ],
        self::MSG_PLEASE_CHECK_HOW_DID_YOU_FIND_US => [
            'en' => 'Please check how did you find us?',
            'ja' => 'どのように知りましたか？に回答して下さい。',
            'ko' => '어떻게 알게 되었나요? 에 회답해 주세요.',
            'sc' => '请回答”怎么知道我们的活动?”',
            'tc' => '請回答”怎麽知道我們的活動？”',
        ],
        self::MSG_THE_EMAIL_ADDRESS_IS_ALREADY_REGISTERED => [
            'en' => 'This e-mail address is already registered.',
            'ja' => 'そのメールアドレスは既に登録されています。',
            'ko' => '이 메일 주소는 이미 등록되어 있습니다.',
            'sc' => '电子邮箱地址已注册。',
            'tc' => 'E-mail地址已註冊。',
        ],
        self::MSG_PLEASE_AGREE_TO_THE_TERMS_AND_CONDITIONS => [
            'en' => 'Please agree to the terms and conditions.',
            'ja' => '会員規約に同意して下さい。',
            'ko' => '회원규약에 동의해 주세요.',
            'sc' => '请同意会员规约。',
            'tc' => '請同意會員規約。',
        ],
        self::MSG_YOUR_REGISTRATION_IS_COMPLETED => [
            'en' => 'Your registration is complete.',
            'ja' => '登録が完了しました。',
            'ko' => '등록이 완료되었습니다.',
            'sc' => '注册完毕。',
            'tc' => '註冊完畢。',
        ],
        self::MSG_PLEASE_ENTER_EMAIL_ADDRESS => [
            'en' => 'Please enter an e-mail address.',
            'ja' => 'メールアドレスを入力して下さい。',
            'ko' => '메일 주소를 입력해 주세요.',
            'sc' => '请输入电子邮件地址。',
            'tc' => '請輸入E-mail地址。',
        ],
        self::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT => [
            'en' => 'Your e-mail address is incorrect.',
            'ja' => 'メールアドレスに誤りがあります。',
            'ko' => '메일 주소가 잘못되었습니다.',
            'sc' => '输入的电子邮件地址有误。',
            'tc' => '輸入的E-mail地址有誤。',
        ],
        self::MSG_PLEASE_RE_ENTER_EMAIL_ADDRESS => [
            'en' => 'Please re-enter e-mail address.',
            'ja' => 'メールアドレス(確認)を入力して下さい。',
            'ko' => '메일 주소(확인)를 입력해 주세요.',
            'sc' => '请输入确认电子邮箱地址。',
            'tc' => '請輸入確認E-mail地址。',
        ],
        self::MSG_YOUR_RE_ENTERED_EMAIL_ADDRESS_IS_NOT_CORRECT => [
            'en' => 'Your re-entered e-mail address is incorrect.',
            'ja' => 'メールアドレス(確認)に誤りがあります。',
            'ko' => '메일 주소(확인)가 잘못되었습니다.',
            'sc' => '输入的确认电子邮箱有地址有误。',
            'tc' => '輸入的確認E-mail地址有誤。',
        ],
        self::MSG_PLEASE_ENTER_PASSWORD => [
            'en' => 'Please enter your password.',
            'ja' => 'パスワードを入力して下さい。',
            'ko' => '비밀번호를 입력해 주세요.',
            'sc' => '请输入密码。',
            'tc' => '請輸入密碼。',
        ],
        self::MSG_YOUR_PASSWORD_IS_NOT_CORRECT => [
            'en' => 'Your password needs to be between 8 and 20 characters.',
            'ja' => 'パスワードは8文字から20文字で入力して下さい。',
            'ko' => '비밀번호는 8-20 문자 또는 숫자로 합니다.',
            'sc' => '密码数位为8-20位，仅用文字和数字。',
            'tc' => '密碼數位為8-20位，僅用文字和數字。',
        ],
        self::MSG_PLEASE_RE_ENTER_PASSWORD => [
            'en' => 'Please re-enter your password.',
            'ja' => 'パスワード(確認)を入力して下さい。',
            'ko' => '비밀번호(확인)를 확인해 주세요.',
            'sc' => '请输入确认密码。',
            'tc' => '請輸入確認密碼。',
        ],
        self::MSG_YOUR_RE_ENTERED_PASSWORD_IS_NOT_CORRECT => [
            'en' => 'Your re-entered password needs to be between 8 and 20 characters.',
            'ja' => 'パスワード(確認)は8文字から20文字で入力して下さい。',
            'ko' => '비밀번호(확인)가 잘못되었습니다.',
            'sc' => '输入的确认密码确认有误。',
            'tc' => '輸入的確認密碼有誤。',
        ],
        self::MSG_PLEASE_ENTER_YOUR_LAST_NAME => [
            'en' => 'Please enter your last name.',
            'ja' => '姓を入力して下さい。',
            'ko' => '성을 입력해 주세요.',
            'sc' => '请输入姓。',
            'tc' => '請輸入姓。',
        ],
        self::MSG_YOUR_LAST_NAME_IS_NOT_CORRECT => [
            'en' => 'Your last name is incorrect.',
            'ja' => '姓に誤りがあります。',
            'ko' => '성이 잘못되었습니다.',
            'sc' => '输入的姓有误。',
            'tc' => '輸入的姓有誤。',
        ],
        self::MSG_PLEASE_ENTER_YOUR_FIRST_NAME => [
            'en' => 'Please enter your first name.',
            'ja' => '名を入力して下さい。',
            'ko' => '이름을 입력해 주세요.',
            'sc' => '请输入名字。',
            'tc' => '請輸入名字。',
        ],
        self::MSG_YOUR_FIRST_NAME_IS_NOT_CORRECT => [
            'en' => 'Your first name is incorrect.',
            'ja' => '名に誤りがあります。',
            'ko' => '이름이 잘못되었습니다.',
            'sc' => '输入的名字有误。',
            'tc' => '輸入的名字有誤。',
        ],
        self::MSG_PLEASE_ENTER_YOUR_POSTAL_CODE => [
            'en' => 'Please enter your postal code.',
            'ja' => '郵便番号を入力して下さい。',
            'ko' => '우편번호를 입력해 주세요.',
            'sc' => '请输入邮政编号。',
            'tc' => '請輸入郵政編號。',
        ],
        self::MSG_YOUR_POSTAL_CODE_IS_NOT_CORRECT => [
            'en' => 'Your postal code is incorrect.',
            'ja' => '郵便番号に誤りがあります。',
            'ko' => '우편번호가 잘못되었습니다.',
            'sc' => '输入的邮政编号有误。',
            'tc' => '輸入的郵政編號有誤。',
        ],
        self::MSG_PLEASE_CHOOSE_THE_COUNTRY => [
            'en' => 'Please choose country.',
            'ja' => '国を選択して下さい。',
            'ko' => '국가를 선택해 주세요.',
            'sc' => '请选择国名。',
            'tc' => '請選擇國名。',
        ],
        self::MSG_YOUR_CHOOSED_COUNTRY_IS_NOT_CORRECT => [
            'en' => 'Your choosen country is incorrect.',
            'ja' => '国の選択に誤りがあります。',
            'ko' => '국가 선택이 잘못되었습니다.',
            'sc' => '您选择的国名有误。',
            'tc' => '您選擇的國名有誤。',
        ],
        self::MSG_PLEASE_ENTER_YOUR_ADDRESS => [
            'en' => 'Please enter your address.',
            'ja' => '住所を入力して下さい。',
            'ko' => '주소를 입력해 주세요.',
            'sc' => '请输入地址。',
            'tc' => '請輸入地址。',
        ],
        self::MSG_YOUR_ADDRESS_IS_NOT_CORRECT => [
            'en' => 'Your address is incorrect.',
            'ja' => '住所に誤りがあります。',
            'ko' => '주소가 잘못되었습니다.',
            'sc' => '输入的地址有误。',
            'tc' => '輸入的地址有誤。',
        ],
        self::MSG_PLEASE_ENTER_TELEPHONE_NUMBER => [
            'en' => 'Please enter telephone number.',
            'ja' => '電話番号を入力して下さい。',
            'ko' => '전화번호를 입력해 주세요.',
            'sc' => '请输入电话号码。',
            'tc' => '請輸入電話號碼。',
        ],
        self::MSG_YOUR_TELEPHONE_NUMBER_IS_NOT_CORRECT => [
            'en' => 'Your telephone number is incorrect.',
            'ja' => '電話番号に誤りがあります。',
            'ko' => '전화번호가 잘못되었습니다.',
            'sc' => '输入的电话号码有误。',
            'tc' => '輸入的電話號碼有誤。',
        ],
        self::MSG_PLEASE_ENTER_MOBILE_NUMBER => [
            'en' => 'Please enter your mobile number.',
            'ja' => '携帯電話番号を入力して下さい。',
            'ko' => '휴대전화번호를 입력해 주세요.',
            'sc' => '请输入手机号码。',
            'tc' => '請輸入手機號碼。',
        ],
        self::MSG_YOUR_MOBILE_NUMBER_IS_NOT_CORRECT => [
            'en' => 'Your mobile number is incorrect.',
            'ja' => '携帯電話番号に誤りがあります。',
            'ko' => '휴대전화번호가 잘못되었습니다.',
            'sc' => '输入的手机号码有误。',
            'tc' => '輸入的手機號碼有誤。',
        ],
        self::MSG_PLEASE_CHOOSE_YOUR_GENDER => [
            'en' => 'Please choose your gender.',
            'ja' => '性別を選択して下さい。',
            'ko' => '성별을 선택해 주세요.',
            'sc' => '请选择性别。',
            'tc' => '請選擇性別。',
        ],
        self::MSG_YOUR_CHOOSED_GENDER_IS_NOT_CORRECT => [
            'en' => 'Your choosen gender is incorrect.',
            'ja' => '性別の選択に誤りがあります。',
            'ko' => '성별 선택이 잘못되었습니다.',
            'sc' => '您选择的性别有误。',
            'tc' => '您選擇的性別有誤。',
        ],
    ];

    public static function getMessage($msg)
    {
        $app  = \Slim\Slim::getInstance();
        $lang = $app->lang;

        if (array_key_exists($msg, self::$messages)) {
            if (isset($lang)) {
                if ($lang == 'test') {
                    $lang = 'en';
                } elseif ($lang == 'ru') {
                    $lang = 'en';
                }

                return self::$messages[$msg][$lang];
            } else {
                return self::$messages[$msg]['en'];
            }
        } else {
            return 'SYSTEM ERROR [Message]';
        }
    }
}