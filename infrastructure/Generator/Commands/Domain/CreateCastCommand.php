<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateCastCommand extends \Illuminate\Foundation\Console\CastMakeCommand
{
    use WithDomainOption;
}
