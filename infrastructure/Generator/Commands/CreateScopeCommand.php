<?php

namespace Infrastructure\Generator\Commands;

class CreateScopeCommand extends \Illuminate\Foundation\Console\ScopeMakeCommand
{
    use WithDomainOption;

    protected function getDefaultNamespace($rootNamespace): string
    {
        if (null !== $this->option('domain')) {
            $scopePath = is_dir($this->getDomainPath('Models')) ? 'Models\\Scopes' : 'Scopes';

            return $this->getDomainNamespace($scopePath);
        }

        return parent::getDefaultNamespace($rootNamespace);
    }
}
