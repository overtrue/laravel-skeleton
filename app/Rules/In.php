<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class In.
 *
 * @author artisan <artisan@tencent.com>
 */
class In implements Rule
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string
     */
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param array       $options
     * @param string|null $message
     */
    public function __construct(array $options, string $message = null)
    {
        $this->options = $options;
        $this->message = $message;
    }

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
        return \in_array($value, $this->options);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message ?: ':attribute不在允许范围';
    }
}
