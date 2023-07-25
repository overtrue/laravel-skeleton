<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateObserverCommand extends \Illuminate\Foundation\Console\ObserverMakeCommand
{
    use WithDomainOption;
}
