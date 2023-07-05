<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Support\Str;

class CreatePolicyCommand extends \Illuminate\Foundation\Console\PolicyMakeCommand
{
    use WithDomainOption;
}
