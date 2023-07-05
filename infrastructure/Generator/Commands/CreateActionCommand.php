<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use TheJano\LaravelDomainDrivenDesign\Helpers\DomainHelper;

class CreateActionCommand extends GeneratorCommand
{
    use WithDomainOption;

    protected $name = 'make:action {name}';

    protected $description = 'Generate a new action class';

    protected $type = 'Action';

    public function handle()
    {
        if (!$this->hasDomain()) {
            $this->error('Domain option is required.');

            return false;
        }

        return parent::handle();
    }

    protected function getStub(): string
    {
        return __DIR__.'/../stubs/action.stub';
    }
}
