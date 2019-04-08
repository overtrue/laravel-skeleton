<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Passport implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return \preg_match('/^([a-zA-z]|[0-9]){5,17}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '护照号码不正确';
    }
}
