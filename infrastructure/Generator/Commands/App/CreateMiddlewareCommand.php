<?php

namespace Infrastructure\Generator\Commands\App;

use Infrastructure\Generator\Commands\WithAppOption;

class CreateMiddlewareCommand extends \Illuminate\Routing\Console\MiddlewareMakeCommand
{
    use WithAppOption;
}
