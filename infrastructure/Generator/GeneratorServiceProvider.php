<?php

namespace Infrastructure\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            Commands\CreateActionCommand::class,
            Commands\CreateCastCommand::class,
            Commands\CreateChannelCommand::class,
            Commands\CreateControllerCommand::class,
            Commands\CreateDomainCommand::class,
            Commands\CreateEndpointCommand::class,
            Commands\CreateEventCommand::class,
            Commands\CreateExceptionCommand::class,
            Commands\CreateFilterCommand::class,
            Commands\CreateJobCommand::class,
            Commands\CreateListenerCommand::class,
            Commands\CreateMailCommand::class,
            Commands\CreateMiddlewareCommand::class,
            Commands\CreateModelCommand::class,
            Commands\CreateNotificationCommand::class,
            Commands\CreateObserverCommand::class,
            Commands\CreatePolicyCommand::class,
            Commands\CreateRequestCommand::class,
            Commands\CreateResourceCommand::class,
            Commands\CreateRuleCommand::class,
            Commands\CreateScopeCommand::class,
        ]);
    }
}
