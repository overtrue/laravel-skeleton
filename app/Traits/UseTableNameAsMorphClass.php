<?php

namespace App\Traits;

trait UseTableNameAsMorphClass
{
    public function getMorphClass()
    {
        return $this->getTable();
    }
}
