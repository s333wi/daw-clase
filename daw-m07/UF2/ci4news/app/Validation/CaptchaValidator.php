<?php

namespace App\Validation;

class CaptchaValidator
{

    public function validateCaptcha($value): bool
    {
        $captcha = session()->get('captcha_text');
        return $value == $captcha;
    }
}
