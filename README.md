Command Bus
===========

[![Build Status](https://travis-ci.org/AshleyDawson/CommandBus.svg?branch=master)](https://travis-ci.org/AshleyDawson/CommandBus)

Super-simple command bus implementation that allows return types. Each command has a **single**, designated handler.

**Note:** Depending on your architecture - it might not be appropriate for commands to return a response. Typically, in [CQS](https://en.wikipedia.org/wiki/Command%E2%80%93query_separation) architecture, state change is observed/measured via events or queries.

Installation
------------

Install the command bus library via [Composer](https://getcomposer.org):

```
$ composer require ashleydawson/command-bus
```

Basic Usage
-----------

To use the command bus, start by adding a command:

```php
<?php

namespace Acme\Command;

class MyCommand
{
    public $something;
}
```

Then, define a command handler for the command, command handlers must implement the magic `__invoke()` method, type-hinted
with the command to be handled:

```php
<?php

namespace Acme\Command;

class MyCommandHandler
{
    public function __invoke(MyCommand $command)
    {
        // Do something with the command here
        
        return 'Something useful';
    }
}
```

Then, put everything together (add command handler to command bus and execute command):

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AshleyDawson\CommandBus\CommandBus;
use Acme\Command\MyCommand;
use Acme\Command\MyCommandHandler;

// Instantiate a command bus
$commandBus = new CommandBus();

// Add a handler to the bus
$commandBus->addHandler(new MyCommandHandler());

// Execute a command, "Something useful" will be echoed
echo $commandBus->execute(new MyCommand());
```

Tests
-----

To run the test suite, execute the following:

```
$ bin/phpunit
```
