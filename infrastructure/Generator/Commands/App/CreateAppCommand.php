<?php

namespace Infrastructure\Generator\Commands\App;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Infrastructure\Generator\AppHelper;

class CreateAppCommand extends GeneratorCommand
{
    const SCAFFOLD_FOLDERS = [
        'Endpoints',
        'Resources',
        'Tests',
    ];

    protected $signature = 'make:app {name}';

    protected $description = 'Scaffold a new app';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));

        foreach (self::SCAFFOLD_FOLDERS as $folder) {
            $path = AppHelper::getPath($name, $folder);

            if (! $this->files->isDirectory($path)) {
                $this->files->makeDirectory($path, 0777, true, true);
            }
        }

        $namespace = AppHelper::getNamespace($name);

        // provider
        $providerName = Str::finish($name, 'ServiceProvider');
        $this->files->put(AppHelper::getPath($name, $providerName.'.php'), $this->sortImports($this->buildClass($providerName)));

        $this->components->info("Application [{$namespace}] created!");
    }

    protected function getStub(): string
    {
        return AppHelper::getStub('service-provider');
    }

    public function getNamespace($name): string
    {
        return AppHelper::getNamespace($this->argument('name'));
    }

    public function rootNamespace(): string
    {
        return AppHelper::getNamespace($this->argument('name'));
    }

    public function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return AppHelper::getPath(str_replace('\\', '/', $name), class_basename($name).'.php');
    }
}
