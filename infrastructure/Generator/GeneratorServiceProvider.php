<?php

namespace Infrastructure\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            // app
            Commands\App\CreateAppCommand::class,
            Commands\App\CreateEndpointCommand::class,
            Commands\App\CreateMiddlewareCommand::class,
            Commands\App\CreateRequestCommand::class,
            Commands\App\CreateResourceCommand::class,
            Commands\App\CreateControllerCommand::class,

            // domain
            Commands\Domain\CreateDomainCommand::class,
            Commands\Domain\CreateActionCommand::class,
            Commands\Domain\CreateFilterCommand::class,

            // override
            Commands\Domain\CreateCastCommand::class,
            Commands\Domain\CreateChannelCommand::class,
            Commands\Domain\CreateEventCommand::class,
            Commands\Domain\CreateExceptionCommand::class,
            Commands\Domain\CreateJobCommand::class,
            Commands\Domain\CreateListenerCommand::class,
            Commands\Domain\CreateMailCommand::class,
            Commands\Domain\CreateModelCommand::class,
            Commands\Domain\CreateNotificationCommand::class,
            Commands\Domain\CreateObserverCommand::class,
            Commands\Domain\CreatePolicyCommand::class,
            Commands\Domain\CreateRuleCommand::class,
            Commands\Domain\CreateScopeCommand::class,
            Commands\Domain\CreateFactoryCommand::class,
        ]);
    }
}
