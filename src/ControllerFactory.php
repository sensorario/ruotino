<?php

namespace App;

use App\UriMatcher\UriMatcher;

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
        if ($this->routes === []) return new BadRequestController;
        $matcher = new UriMatcher(array_keys($this->routes), $action);
        if ($matcher->match()) {
            $controller = new $this->routes[$matcher->getPath()]();

            $context->setData($matcher->getData());

            return $controller;
        }
    }
}
