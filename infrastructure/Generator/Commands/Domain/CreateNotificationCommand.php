<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateNotificationCommand extends \Illuminate\Foundation\Console\NotificationMakeCommand
{
    use WithDomainOption;
}
