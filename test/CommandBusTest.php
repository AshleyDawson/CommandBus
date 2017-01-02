<?php

namespace AshleyDawson\CommandBus\Test;

use AshleyDawson\CommandBus\CommandBus;
use AshleyDawson\CommandBus\Test\Dummy\InvalidCommandHandler;
use AshleyDawson\CommandBus\Test\Dummy\ValidCommand;
use AshleyDawson\CommandBus\Test\Dummy\ValidCommandHandler;
use AshleyDawson\CommandBus\Test\Dummy\ValidCommandHandlerTwo;

/**
 * Class CommandBusTest
 *
 * @package AshleyDawson\CommandBus\Test
 */
class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->bus = new CommandBus();
    }

    /**
     * @test
     */
    public function bus_accepts_valid_handler()
    {
        $this->bus->addHandler(new ValidCommandHandler());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function bus_does_not_accept_array_handler()
    {
        $this->bus->addHandler(['foo' => 'bar']);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function bus_does_not_accept_invalid_handler()
    {
        $this->bus->addHandler(new InvalidCommandHandler());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function bus_already_has_handler_for_command()
    {
        $this->bus->addHandler(new ValidCommandHandler());
        $this->bus->addHandler(new ValidCommandHandlerTwo());
    }

    /**
     * @test
     */
    public function bus_executes_valid_command()
    {
        $this->bus->addHandler(new ValidCommandHandler());

        $response = $this->bus->execute(new ValidCommand());

        $this->assertEquals('valid_command_handler_executed', $response);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function bus_fails_to_execute_array_command()
    {
        $this->bus->addHandler(new ValidCommandHandler());

        $response = $this->bus->execute(['foo' => 'bar']);

        $this->assertEquals('valid_command_handler_executed', $response);
    }
}
