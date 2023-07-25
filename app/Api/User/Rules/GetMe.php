<?php

namespace App\Api\User\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GetMe implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
}
