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
        $static = in_array($action, array_keys($this->routes))
            ? $action
            : null;
        
        if ($static === null) {
            foreach(array_keys($this->routes) as $path) {
                if (strpos($path, ':') != 0) {
                    return $action;
                }
            }
        }

        return $static;
    }

    private function controller($action) {
        if (!isset($this->routes[$action])) {
            foreach(array_keys($this->routes) as $path) {
                if (strpos($path, ':') != 0) {
                    return new $this->routes[$path];
                }
            }
        }

        return new $this->routes[$action];
    }
}
