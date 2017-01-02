<?php

namespace AshleyDawson\CommandBus;

/**
 * Class CommandBus
 *
 * @package AshleyDawson\CommandBus
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @var object[]
     */
    private $handlers = [];

    /**
     * @var string[]
     */
    private $handlerTypes = [];

    /**
     * {@inheritdoc}
     */
    public function addHandler($handler)
    {
        $this->assertHandlerIsValid($handler);

        $type = $this->getHandlerSupportedCommandType($handler);

        $this->handlers[$type] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        $this->assertCommandIsExecutable($command);

        return $this->handlers[get_class($command)]($command);
    }

    /**
     * @param object $command
     * @throws \InvalidArgumentException
     */
    private function assertCommandIsExecutable($command)
    {
        if (! is_object($command)) {
            throw new \InvalidArgumentException(sprintf(
                'Command must be an object, "%s" given',
                gettype($command)
            ));
        }

        $type = get_class($command);

        if (! isset($this->handlers[$type])) {
            throw new \InvalidArgumentException(sprintf(
                'Command handler not found for command "%s"',
                $type
            ));
        }
    }

    /**
     * @param object $handler
     * @throws \InvalidArgumentException
     */
    private function assertHandlerIsValid($handler)
    {
        if (! is_object($handler)) {
            throw new \InvalidArgumentException(sprintf(
                'Command handler must be an object, "%s" given',
                gettype($handler)
            ));
        }

        if (! method_exists($handler, '__invoke')) {
            throw new \InvalidArgumentException(sprintf(
                'Command handler "%s" must implement an "__invoke(MyCommandType $command)" method',
                get_class($handler)
            ));
        }

        $type = $this->getHandlerSupportedCommandType($handler);

        if (isset($this->handlers[$type])) {
            throw new \InvalidArgumentException(sprintf(
                'Cannot add command handler "%s" as a handler for the command "%s" already exists',
                get_class($handler),
                $type
            ));
        }
    }

    /**
     * @param object $handler
     * @return string
     * @throws \InvalidArgumentException
     */
    private function getHandlerSupportedCommandType($handler)
    {
        $handlerClass = get_class($handler);

        if (isset($this->handlerTypes[$handlerClass])) {
            return $this->handlerTypes[$handlerClass];
        }

        $parameters = (new \ReflectionMethod($handler, '__invoke'))
            ->getParameters();

        if (! isset($parameters[0])) {
            throw new \InvalidArgumentException(sprintf(
                'Command handler "%s" must implement an "__invoke(MyCommandType $command)" method, accepting a '
                .'single type-hinted argument - that of the command',
                $handlerClass
            ));
        }

        if (null === ($class = $parameters[0]->getClass())) {
            throw new \InvalidArgumentException(sprintf(
                'Command handler %s#__invoke() method must have a single type-hinted argument, that of the supported command',
                $handlerClass
            ));
        }

        return $this->handlerTypes[$handlerClass] = $class->getName();
    }
}
