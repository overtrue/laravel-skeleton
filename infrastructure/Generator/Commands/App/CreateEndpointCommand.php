<?php

namespace Infrastructure\Generator\Commands\App;

class CreateEndpointCommand extends CreateControllerCommand
{
    protected $name = 'make:endpoint';

    protected $description = 'Create a new endpoint class';

    public function getAppendNamespace(): string
    {
        return 'Endpoints';
    }
}
