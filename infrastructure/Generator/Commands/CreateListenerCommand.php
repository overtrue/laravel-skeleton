<?php

namespace Infrastructure\Generator\Commands;

use Illuminate\Support\Str;

class CreateListenerCommand extends \Illuminate\Foundation\Console\ListenerMakeCommand
{
    use WithDomainOption;

    protected function buildClass($name): array|string
    {
        $event = $this->option('event');
        $domain = $this->option('domain');
        $namespace = null !== $domain ? $this->getDomainNamespace() : $this->laravel->getNamespace();

        if (! Str::startsWith(
            $event,
            [
                $this->laravel->getNamespace(),
                'Illuminate',
                '\\',
            ]
        )) {
            $event = $namespace.'Events\\'.str_replace('/', '\\', $event);
        }

        $stub = str_replace(
            ['DummyEvent', '{{ event }}'],
            class_basename($event),
            $this->parentBuildClass($name)
        );

        return str_replace(['DummyFullEvent', '{{ eventNamespace }}'], trim($event, '\\'), $stub);
    }

    protected function parentBuildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }
}
