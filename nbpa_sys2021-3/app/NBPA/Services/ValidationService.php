<?php

/**
 * @version SVN: $Id: ValidationService.php 136 2015-06-08 14:32:05Z morita $
 */
namespace NBPA\Services;

use NBPA\Models\Message;
use Respect\Validation\Validator as v;

class ValidationService
{
    /**
     * メールアドレス.
     */
    public static function validateEmail($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_EMAIL_ADDRESS);
        } elseif (!v::email()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_EMAIL_ADDRESS_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * メールアドレス(確認).
     */
    public static function validateReEmail($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_RE_ENTER_EMAIL_ADDRESS);
        } elseif (!v::email()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_RE_ENTERED_EMAIL_ADDRESS_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * パスワード.
     */
    public static function validatePassword($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_PASSWORD);
        } elseif (!v::graph()->length(8, 20)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * パスワード(確認).
     */
    public static function validateRePassword($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_RE_ENTER_PASSWORD);
        } elseif (!v::graph()->length(8, 20)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_RE_ENTERED_PASSWORD_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * パスワード(更新).
     */
    public static function validatePasswordNotNecessary($target)
    {
        $errors = [];

        if (strlen($target) > 0) {
            if (!v::graph()->length(8, 20)->validate($target)) {
                $errors[] = Message::getMessage(Message::MSG_YOUR_PASSWORD_IS_NOT_CORRECT);
            }
        }

        return $errors;
    }

    /**
     * パスワード(確認)(更新).
     */
    public static function validateRePasswordNotNecessary($target)
    {
        $errors = [];

        if (strlen($target) > 0) {
            if (!v::graph()->length(8, 20)->validate($target)) {
                $errors[] = Message::getMessage(Message::MSG_YOUR_RE_ENTERED_PASSWORD_IS_NOT_CORRECT);
            }
        }

        return $errors;
    }

    /**
     * 姓.
     */
    public static function validateLastName($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_YOUR_LAST_NAME);
        } elseif (!v::string()->length(1, 80)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_LAST_NAME_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 名.
     */
    public static function validateFirstName($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_YOUR_FIRST_NAME);
        } elseif (!v::string()->length(1, 80)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_FIRST_NAME_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 郵便番号.
     */
    public static function validatePostalCode($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_YOUR_POSTAL_CODE);
        } elseif (!v::string()->length(1, 80)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_POSTAL_CODE_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 国.
     */
    public static function validateCountry($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_CHOOSE_THE_COUNTRY);
        } elseif ($target === '0') {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_CHOOSE_THE_COUNTRY);
        } elseif (!v::int()->between(1, 249, true)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_CHOOSED_COUNTRY_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 住所.
     */
    public static function validateAddress($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_YOUR_ADDRESS);
        } elseif (!v::string()->length(1, 80)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_ADDRESS_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 電話番号.
     */
    public static function validateTelephone($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_TELEPHONE_NUMBER);
        } elseif (!v::string()->length(1, 20)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_TELEPHONE_NUMBER_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 携帯電話番号.
     */
    public static function validateMobile($target)
    {
        $errors = [];

        if (strlen($target) > 0) {
            if (!v::string()->length(1, 20)->validate($target)) {
                $errors[] = Message::getMessage(Message::MSG_YOUR_MOBILE_NUMBER_IS_NOT_CORRECT);
            }
        }

        return $errors;
    }

    /**
     * 性別.
     */
    public static function validateGender($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_CHOOSE_YOUR_GENDER);
        } elseif ($target === '0') {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_CHOOSE_YOUR_GENDER);
        } elseif (!v::int()->between(1, 2, true)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_YOUR_CHOOSED_GENDER_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * 作品タイトル.
     */
    public static function validateTitle($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_THE_TITLE);
        } elseif (!v::string()->length(1, 80)->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_THE_TITLE_IS_NOT_CORRECT);
        }

        return $errors;
    }

    /**
     * YouTube 埋め込みコード
     */
    public static function validateEmbedcode($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = Message::getMessage(Message::MSG_PLEASE_ENTER_EMBEDCODE);
        }

        return $errors;
    }

    /**
     * 審査員名前.
     */
    public static function validateJudgeName($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter judge name.';
        }

        return $errors;
    }

    /**
     * 審査員割り当て.
     */
    public static function validateJudgeQuota($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter quota of point.';
        } elseif (!v::int()->between(1, 10, true)->validate($target)) {
            $errors[] = 'Quota of point needs to be between 1 and 10.';
        }

        return $errors;
    }

    /**
     * 撮影場所.
     */
    public static function validateLocation($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the location name.';
        } elseif (!v::string()->length(1, 32)->validate($target)) {
            $errors[] = 'Too long location name.';
        }

        return $errors;
    }

    /**
     * カメラ.
     */
    public static function validateCamera($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the model name of the camera.';
        } elseif (!v::string()->length(1, 64)->validate($target)) {
            $errors[] = 'Too long camera name.';
        }

        return $errors;
    }

    /**
     * レンズ.
     */
    public static function validateLens($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the model name of the lens.';
        } elseif (!v::string()->length(1, 64)->validate($target)) {
            $errors[] = 'Too long lens name.';
        }

        return $errors;
    }

    /**
     * シャッタースピード.
     */
    public static function validateSpeed($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the shutter speed.';
        } elseif (!v::string()->length(1, 32)->validate($target)) {
            $errors[] = 'Too long shutter speed.';
        }

        return $errors;
    }

    /**
     * F値.
     */
    public static function validateFnum($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the F number.';
        } elseif (!v::string()->length(1, 16)->validate($target)) {
            $errors[] = 'Too long F number.';
        }

        return $errors;
    }

    /**
     * ISO感度.
     */
    public static function validateISO($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the film speed (ISO).';
        } elseif (!v::string()->length(1, 32)->validate($target)) {
            $errors[] = 'Too long film speed.';
        }

        return $errors;
    }

    /**
     * フラッシュ.
     */
    public static function validateFlash($target)
    {
        $errors = [];

        if (v::notEmpty()->validate($target)) {
            if (!v::string()->length(1, 64)->validate($target)) {
                $errors[] = 'Too long flash name.';
            }
        }

        return $errors;
    }

    /**
     * 三脚.
     */
    public static function validateTripod($target)
    {
        $errors = [];

        if (v::notEmpty()->validate($target)) {
            if (!v::string()->length(1, 64)->validate($target)) {
                $errors[] = 'Too long tripod name.';
            }
        }

        return $errors;
    }

    /**
     * 写真コメント.
     */
    public static function validateComment($target)
    {
        $errors = [];

        if (!v::notEmpty()->validate($target)) {
            $errors[] = 'Please enter the comment of the photo.';
        }

        return $errors;
    }
}
