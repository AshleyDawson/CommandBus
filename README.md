Command Bus
===========

Super-simple command bus implementation that allows return types. Each command has a **single**, designated handler.

Installation
------------

Install the command bus library via [Composer](https://getcomposer.org):

```
$ composer require ashleydawson/command-bus
```

Basic usage
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