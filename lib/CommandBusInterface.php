<?php

namespace AshleyDawson\CommandBus;

/**
 * Interface CommandBusInterface
 *
 * @package AshleyDawson\CommandBus
 */
interface CommandBusInterface
{
    /**
     * Add a command handler
     *
     * @param object $handler
     */
    public function addHandler($handler);

    /**
     * Execute a given command against a designated handler
     *
     * @param object $command
     * @return mixed
     */
    public function execute($command);
}