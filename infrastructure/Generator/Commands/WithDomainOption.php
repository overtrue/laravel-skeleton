<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Support\Str;
use Infrastructure\Generator\DomainHelper;
use Symfony\Component\Console\Input\InputOption;

trait WithDomainOption
{
    protected function getOptions(): array
    {
        return array_merge(
            [
                ['domain', 'd', InputOption::VALUE_OPTIONAL, 'Provide domain name.'],
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
        if ($this->hasDomain()) {
            return DomainHelper::getNamespace($this->option('domain'), $this->getAppendNamespace());
        }

        return $rootNamespace.'/'.$this->getAppendNamespace();
    }

    protected function rootNamespace()
    {
        return $this->hasDomain() ? DomainHelper::getNamespace($this->option('domain')) : parent::rootNamespace();
    }

    protected function getPath($name)
    {
        if ($this->hasDomain()) {
            $name = Str::replaceFirst($this->rootNamespace(), '', $name);

            return DomainHelper::getPath($this->option('domain'), str_replace('\\', '/', $name).'.php');
        }

        return parent::getPath($name);
    }

    protected function hasDomain(): bool
    {
        return null !== $this->option('domain');
    }
}
