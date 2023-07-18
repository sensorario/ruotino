<?php

namespace App;

class ControllerFactory
{
    public function __construct(
        private array $routes = [],
    ) {
    }

    public function getController(string $action): Command
    {
        return match($action) {
            $this->route($action) => $this->controller($action),
            default => new BadRequestController,
        };
    }

    private function route($action) {
        return in_array($action, array_keys($this->routes))
            ? $action
            : null;
    }

    private function controller($action) {
        return new $this->routes[$action];
    }
}
