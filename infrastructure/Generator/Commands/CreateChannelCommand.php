<?php

namespace Infrastructure\Generator\Commands;

class CreateChannelCommand extends \Illuminate\Foundation\Console\ChannelMakeCommand
{
    use WithDomainOption;

    public function getAppendNamespace(): string
    {
        return 'Broadcasting';
    }
}
