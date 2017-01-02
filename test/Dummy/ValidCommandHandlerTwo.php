<?php

namespace AshleyDawson\CommandBus\Test\Dummy;

class ValidCommandHandlerTwo
{
    public function __invoke(ValidCommand $command)
    {
        return 'valid_command_handler_two_executed';
    }
}
