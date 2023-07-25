<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateEventCommand extends \Illuminate\Foundation\Console\EventMakeCommand
{
    use WithDomainOption;
}
