<?php

namespace App;

class ControllerFactory
{
    public function __construct(
        private array $routes = [],
    ) {
    }

    public function getController(
        string $action,
        RequestContext $context
    ): Command {
        return match($action) {
            $this->route($action) => $this->controller($action, $context),
            default => new BadRequestController,
        };
    }

    private function route($action) {
        if (in_array($action, array_keys($this->routes))) return $action;
        
        foreach(array_keys($this->routes) as $path) {
            if (strpos($path, ':') != 0) return $action;
        }
    }

    private function controller($action, RequestContext $context) {
        if (!isset($this->routes[$action])) {
            foreach(array_keys($this->routes) as $path) {
                if (strpos($path, ':') != 0) {
                    $explodedPath = explode('/', $path);
                    $explodedAction = explode('/', $action);
                    if (
                        $explodedAction[1] === $explodedPath[1]
                        && count($explodedAction) === count($explodedPath)
                    ) {
                        // $context->setVars
                        $data = [];
                        $data[current(array_diff($explodedPath, $explodedAction))] = current(array_diff($explodedAction, $explodedPath));
                        $context->setData($data);

                        return new $this->routes[$path]();
                    }
                }
            }
        }

        return new $this->routes[$action];
    }
}
