<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateChannelCommand extends \Illuminate\Foundation\Console\ChannelMakeCommand
{
    use WithDomainOption;

    public function getAppendNamespace(): string
    {
        return 'Broadcasting';
    }
}
