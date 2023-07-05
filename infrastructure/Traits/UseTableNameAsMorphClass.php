<?php

namespace Infrastructure\Traits;

trait UseTableNameAsMorphClass
{
    public function getMorphClass(): string
    {
        return $this->getTable();
    }
}
