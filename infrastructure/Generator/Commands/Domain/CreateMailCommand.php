<?php

namespace Infrastructure\Generator\Commands\Domain;

use Infrastructure\Generator\Commands\WithDomainOption;

class CreateMailCommand extends \Illuminate\Foundation\Console\MailMakeCommand
{
    use WithDomainOption;
}
