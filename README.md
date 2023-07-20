# Ruotino

## Add ruotinto to your code

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
