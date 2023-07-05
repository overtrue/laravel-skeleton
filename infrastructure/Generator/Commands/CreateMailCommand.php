<?php

namespace Infrastructure\Generator\Commands;

class CreateMailCommand extends \Illuminate\Foundation\Console\MailMakeCommand
{
    use WithDomainOption;
}
