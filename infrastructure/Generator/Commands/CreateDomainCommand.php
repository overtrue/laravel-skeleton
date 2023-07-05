<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Infrastructure\Generator\DomainHelper;

class CreateDomainCommand extends Command
{
    const SCAFFOLD_FOLDERS = [
        'Endpoints',
        'Policies',
        'Requests',
        'Scopes',
    ];

    protected $signature = 'make:domain {name}';

    protected $description = 'Scaffold a new domain';

    protected $type = 'Domain';

    public function handle(): void
    {
        $name = Str::studly($this->argument('name'));

        foreach (self::SCAFFOLD_FOLDERS as $folder) {
            $this->makeDirectory(DomainHelper::getPath($name,$folder));
        }

        $namespace = DomainHelper::getNamespace($name);

        $this->components->info("{$this->type} [{$namespace}] domain created!");
    }

    public function makeDirectory(string $path, int $mode = 0755, bool $recursive = true, bool $force = true): void
    {
        File::makeDirectory($path, $mode, $recursive, $force);
    }
}
