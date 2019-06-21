<?php

namespace App\Console\Commands;

class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    /**
     * @return string
     */
    public function getStub()
    {
        $custom = __DIR__. \strstr(parent::getStub(), '/stubs');

        if (\file_exists($custom)) {
            return $custom;
        }

        return parent::getStub();
    }
}
