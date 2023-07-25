<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreatePolicyCommand extends \Illuminate\Foundation\Console\PolicyMakeCommand
{
    use WithDomainOption;
}
