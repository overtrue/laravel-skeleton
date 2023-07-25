<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateExceptionCommand extends \Illuminate\Foundation\Console\ExceptionMakeCommand
{
    use WithDomainOption;
}
