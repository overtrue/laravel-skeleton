<?php

namespace Infrastructure\Generator\Commands\Domain;

use Illuminate\Support\Str;
use Infrastructure\Generator\Commands\WithDomainOption;

class CreateModelCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    use WithDomainOption;

    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', array_filter([
            'name' => "{$controller}",
            '--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            '--api' => $this->option('domain') ? true : $this->option('api'),
            '--requests' => $this->option('requests') || $this->option('all'),
            '--domain' => $this->option('domain'),
        ]));
    }

    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $this->call('make:policy', [
            'name' => "{$policy}Policy",
            '--model' => $this->qualifyClass($this->getNameInput()),
            '--domain' => $this->option('domain'),
        ]);
    }
}
