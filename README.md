# Ruotino

## Front Controller

```php
<?php

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

## CiaoneController

```php
<?php

namespace App;

class CiaoneController implements Command
{
    public function get($context)
    {
        $context->setResponse([
            'code' => 200,
            'message' => 'OK'
        ]);
    }
}
```