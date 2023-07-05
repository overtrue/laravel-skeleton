<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Support\Str;
use Infrastructure\Generator\AppHelper;
use Symfony\Component\Console\Input\InputOption;

trait WithAppOption
{
    protected function getOptions(): array
    {
        return array_merge(
            [
                ['app', 'a', InputOption::VALUE_OPTIONAL, 'Provide app name.'],
            ],
            parent::getOptions()
        );
    }

    public function getAppendNamespace(): string
    {
        // CreateScopeCommand => Scopes
        return Str::plural(substr(class_basename(__CLASS__), strlen('create'), -strlen('Command')));
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if ($this->hasApp()) {
            return AppHelper::getNamespace($this->option('app'), $this->getAppendNamespace());
        }

        return $rootNamespace;
    }

    protected function rootNamespace()
    {
        return $this->hasApp() ? AppHelper::getNamespace($this->option('app')) : parent::rootNamespace();
    }

    protected function getPath($name)
    {
        if ($this->hasApp()) {
            $name = Str::replaceFirst($this->rootNamespace(), '', $name);

            return AppHelper::getPath($this->option('app'), str_replace('\\', '/', $name).'.php');
        }

        return parent::getPath($name);
    }

    protected function hasApp(): bool
    {
        return null !== $this->option('app');
    }
}
