<?php

namespace Infrastructure\Generator\Commands\Domain;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Support\Str;
use Infrastructure\Generator\Commands\WithDomainOption;

class CreateFactoryCommand extends FactoryMakeCommand
{
    use WithDomainOption;

    protected function buildClass($name)
    {
        if (! $this->hasDomain()) {
            return parent::buildClass($name);
        }

        $factory = class_basename(Str::ucfirst(str_replace('Factory', '', $name)));

        $namespaceModel = $this->option('model')
            ? $this->qualifyModel($this->option('model'))
            : $this->qualifyModel($this->guessModelName($name));

        $model = class_basename($namespaceModel);

        $namespace = $this->getNamespace($this->qualifyClass($this->getNameInput()));

        $replace = [
            '{{ factoryNamespace }}' => $namespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            '{{ factory }}' => $factory,
            '{{factory}}' => $factory,
        ];

        $stub = $this->files->get($this->getStub());

        $content = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        return str_replace(
            array_keys($replace), array_values($replace), $content
        );
    }

    /**
     * Guess the model name from the Factory name or return a default model name.
     *
     * @param  string  $name
     * @return string
     */
    protected function guessModelName($name)
    {
        if (! $this->hasDomain()) {
            return parent::buildClass($name);
        }

        if (str_ends_with($name, 'Factory')) {
            $name = substr($name, 0, -7);
        }

        $modelName = $this->rootNamespace().'\\'.class_basename($name);

        if (class_exists($modelName)) {
            return $modelName;
        }

        if (is_dir($this->getPath('Models/'))) {
            return $this->rootNamespace().'Models\\'.$name;
        }

        return $this->getNamespace($name);
    }
}
