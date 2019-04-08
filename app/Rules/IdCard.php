<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IdCard implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isChinaIdNo($value) || $this->isTWIdCardNo($value) || $this->isHKIdCardNo($value);
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return '身份证号码不正确';
    }

    /**
     * @param $value
     *
     * @return false|int
     */
    protected function isTWIdCardNo($value)
    {
        return \preg_match('/^\d{8}|^[a-zA-Z0-9]{10}|^\d{18}$/', $value);
    }

    /**
     * @param $value
     *
     * @return false|int
     */
    protected function isHKIdCardNo($value)
    {
        return \preg_match('/^([A-Z]\d{6,10}(\(\w{1}\))?)$/', $value);
    }

    /**
     * @param $value
     *
     * @return false|int
     */
    protected function isChinaIdNo($value)
    {
        return \preg_match('/^(([1][1-5])|([2][1-3])|([3][1-7])|([4][1-6])|([5][0-4])|([6][1-5])|([7][1])|([8][1-2]))\d{4}(([1][9]\d{2})|([2]\d{3}))(([0][1-9])|([1][0-2]))(([0][1-9])|([1-2][0-9])|([3][0-1]))\d{3}[0-9xX]$/', $value);
    }
}
