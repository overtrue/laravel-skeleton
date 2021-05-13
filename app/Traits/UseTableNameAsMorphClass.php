<?php

namespace App\Traits;

trait UseTableNameAsMorphClass
{
    public function getMorphClass(): string
    {
        return $this->getTable();
    }
}
