<?php

namespace Infrastructure\Generator\Commands;

use EloquentFilter\Commands\MakeEloquentFilter;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Support\Str;
use Infrastructure\Generator\DomainHelper;

class CreateFilterCommand extends MakeEloquentFilter
{
    use WithDomainOption;
    use InteractsWithIO;

    protected $signature = 'make:filter {name} {--d|domain=}';

    protected $description = 'Generate a new query filter class';

    public function handle()
    {
        $this->makeClassName()->compileStub();
        $this->components->info(sprintf('%s [%s] created successfully.', class_basename($this->getClassName()), $this->getPath()));
    }

    public function getAppendNamespace(): string
    {
        return 'Filters';
    }

    public function getPath(): string
    {
        if ($this->hasDomain()) {
            return DomainHelper::getPath($this->option('domain'),  $this->getFileName());
        }

        return $this->laravel->basePath($this->getFileName());
    }

    public function getAppNamespace(): string
    {
        if ($this->hasDomain()) {
            return DomainHelper::getNamespace($this->option('domain'));
        }

        return $this->laravel->getNamespace();
    }

    public function makeClassName()
    {
        if ($this->hasDomain()) {
            $parts = array_map([Str::class, 'studly'], explode('\\', $this->argument('name')));
            $className = array_pop($parts);
            $ns = count($parts) > 0 ? implode('\\', $parts).'\\' : '';

            $fqClass = DomainHelper::getNamespace($this->option('domain'), "Filters", $ns.$className);

            if (!str_ends_with($fqClass, 'Filter')) {
                $fqClass .= 'Filter';
            }

            if (class_exists($fqClass)) {
                $this->components->error("$fqClass Already Exists!");
                exit;
            }

            $this->setClassName($fqClass);

            return $this;
        }

        return parent::makeClassName();
    }
}
