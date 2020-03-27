<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return parent::getStub();
        }

        return __DIR__ . '/stubs/model.stub';
    }

    public function handle()
    {
        parent::handle();

        if ($this->option('all')) {
            $this->createPolicy();
        }
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));
        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:policy', [
            'name' => Str::finish($policy, 'Policy'),
            '--model' => Str::replaceFirst('App\\', '', $modelName),
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') ? $modelName : null,
            '--api' => true,
        ]);
    }
}
