<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateJobCommand extends \Illuminate\Foundation\Console\JobMakeCommand
{
    use WithDomainOption;
}
