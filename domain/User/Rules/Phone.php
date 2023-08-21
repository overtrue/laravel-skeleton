<?php

namespace Domain\User\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (! preg_match('/^1(3[0-9]|4[57]|5[0-35-9]|6[6]|7[0135678]|8[0-9])\d{8}$/', $value)) {
            $fail('仅支持中国大陆手机号码');
        }
    }
}
