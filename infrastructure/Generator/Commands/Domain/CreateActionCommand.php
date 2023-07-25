<?php

namespace Infrastructure\Generator\Commands\Domain;

use Illuminate\Console\GeneratorCommand;
use Infrastructure\Generator\Commands\WithDomainOption;
use Infrastructure\Generator\DomainHelper;

class CreateActionCommand extends GeneratorCommand
{
    use WithDomainOption;

    protected $name = 'make:action {name}';

    protected $description = 'Generate a new action class';

    protected $type = 'Action';

    public function handle()
    {
        if (! $this->hasDomain()) {
            $this->error('Domain option is required.');

            return false;
        }

        return parent::handle();
    }

    protected function getStub(): string
    {
        return DomainHelper::getStub('action');
    }
}
