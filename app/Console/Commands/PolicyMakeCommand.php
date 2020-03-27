<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;

class PolicyMakeCommand extends \Illuminate\Foundation\Console\PolicyMakeCommand
{
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/policy.stub';
    }

    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());

        if (!$this->hasOption('model')) {
            $this->input->setOption('model', Str::replaceLast('Policy', '', class_basename($name)));
        }

        $this->createParentPolicyIfNotExists();

        return parent::handle();
    }

    protected function createParentPolicyIfNotExists(): void
    {
        $name = $this->qualifyClass('Policy');

        if ($this->alreadyExists($name)) {
            return;
        }

        $path = $this->getPath($name);

        $this->makeDirectory($path);

        $stub = $this->files->get(__DIR__ . '/stubs/abstract-policy.stub');

        $this->files->put($path, $this->replaceNamespace($stub, $name)->replaceClass($stub, $name));

        $this->info('Abstract Policy created successfully.');
    }
}
