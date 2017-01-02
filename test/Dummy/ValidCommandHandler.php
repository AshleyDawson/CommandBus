<?php

namespace AshleyDawson\CommandBus\Test\Dummy;

class ValidCommandHandler
{
    public function __invoke(ValidCommand $command)
    {
        return 'valid_command_handler_executed';
    }
}
