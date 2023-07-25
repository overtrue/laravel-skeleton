<?php

namespace Infrastructure\Generator\Commands\App;

use Infrastructure\Generator\Commands\WithAppOption;

class CreateRequestCommand extends \Illuminate\Foundation\Console\RequestMakeCommand
{
    use WithAppOption;
}
