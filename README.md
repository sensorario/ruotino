# Ruotino

```
composer create-project sensorario/ruotino laruotadellafortuna
cd laruotadellafortuna
php init.php
make up
```

Then open http://localhost:8894/ciaone

## Routing

This is a sample front controller. With two routes. Former is static and latter is dynamic. Second one works with routes like `/mondone/42` or `/mondone/foo`. Whenever dynamic path is `/foo/:bar` and current request uri is `/foo/42`, `$context->getData()` inside the controller contains `[":bar" => "42"]`.

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\JsonServer;
use App\RequestContext;
use App\ControllerFactory;

$routes = [
    '/ciaone' => App\CiaoneController::class,
    '/mondone/:number' => App\MondoneController::class,
];

echo (new JsonServer(
    new RequestContext,
    new ControllerFactory($routes),
))();
```

## Alternative

### require the framework

```
composer require sensorario/ruotino
```

### fix composer.json

```
"autoload": {
	"psr-4": {
		"App\\": ["src"]
	}
}
```

### create public/index file

```
require_once __DIR__ . '/../vendor/autoload.php';

use App\JsonServer;
use App\RequestContext;
use App\ControllerFactory;

$routes = [
    '/ciaone' => App\CiaoneController::class
];

echo (new JsonServer(
    new RequestContext,
    new ControllerFactory($routes),
))();
```

### Create first controller

```php
namespace App;

class CiaoneController implements Command
{
    public function get($context) {
        $context->setResponse(['foo' => 'bar']);
    }
}
```
