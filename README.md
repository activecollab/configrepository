# Configuration Repository

This package provides a way to compose a configuration repository that reads and write options from serveral sources.

## Working with data

Repository provides a couple of confenient methods to retrive and set the data:

```php
<?php

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

$repository = new ConfigRepository(new PhpConstantsAdapter('/path/to/config.php'));

// Check if option exists in any of the adapters
$repository->exists('CONFIG_NAME');

// Get value from first adapter that has it, or return default value if none of the adapters have it
$repository->get('CONFIG_NAME', 'default if not found');

// Get value from first adapter that has it, or throw an exception if it is not found in any adapter
$repository->mustGet('CONFIG_NAME'); // Throws an exception if option is not fpund

// Set value in all adapters where this option exists. Read-only adapters that have this option will throw an exception
$repository->set('CONFIG_NAME', 'value to set');
```

To work with the data from a particular adapter, find it and use the same methods:

```php
<?php

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

$repository = new ConfigRepository(new PhpConstantsAdapter('/path/to/config.php'));

$repository->getAdapter(PhpConstantsAdapter::class)->exists('CONFIG_NAME');
$repository->getAdapter(PhpConstantsAdapter::class)->get('CONFIG_NAME', 'default if not found');
$repository->getAdapter(PhpConstantsAdapter::class)->mustGet('CONFIG_NAME'); // Throws an exception if option is not fpund
$repository->getAdapter(PhpConstantsAdapter::class)->set('CONFIG_NAME', 'value to set');
```

## Adapter Composition

When constructing a repository instance, you can specify a list of adapters:

```php
<?php

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\DotEnvAdapter;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

$repository = new ConfigRepository(new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'), new DotEnvAdapter(__DIR__ . '/Resources', '.env'));
```

Adapters added like this will be indexed by their class names, so instances of the same class can't be added like this. To do that, provide an array, where key is adaper name and value is adapter instance (if key is missing, library will use adapter's class as adapter name):

```php
<?php

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\DotEnvAdapter;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

$repository = new ConfigRepository([
    new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'),
    'second' => new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'),
], new DotEnvAdapter(__DIR__ . '/Resources', '.env'));

$repository->getAdapter(PhpConstantsAdapter::class); // Returns PhpConstantsAdapter instance
$repository->getAdapter('second');                   // Returns PhpConstantsAdapter instance
$repository->getAdapter(DotEnvAdapter::class);       // Returns DotEnvAdapter instance
```

Adapters can also be added at any time, using `addAdapter()` method:

```php
<?php

use ActiveCollab\ConfigRepository\ConfigRepository;
use ActiveCollab\ConfigRepository\Adapter\DotEnvAdapter;
use ActiveCollab\ConfigRepository\Adapter\PhpConstantsAdapter;

$repository = new ConfigRepository(new PhpConstantsAdapter(__DIR__ . '/Resources/config.simple.php'));
$repository->addAdapter(new DotEnvAdapter($repository->get('DOT_ENV_DIR_PATH')));
```
