<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

class Polymorphic implements Rule
{
    public function __construct(protected string $name, protected ?string $message = null)
    {
    }

    public function passes($attribute, $value): bool
    {
        $model = request()->get(\sprintf('%s_type', $this->name));

        $model = Relation::getMorphedModel($model) ?? $model;

        return \class_exists($model) && \call_user_func([$model, 'find'], \request()->get(\sprintf('%s_id', $this->name)));
    }

    public function message(): string
    {
        return $this->message ?: '未指定目标或目标不存在';
    }
}
