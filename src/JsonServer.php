<?php

namespace App;

class JsonServer
{
    public function __construct(
        private RequestContext $context = new RequestContext,
        private ControllerFactory $factory = new ControllerFactory,
    ) { }

    public function __invoke(): string
    {
        $action = $this->context->action();
        $method = $this->context->method();

        $controller = $this->factory->getController($action);

        if (method_exists($controller, $method)) {
            $controller->$method($this->context);
        } else {
            (new NotAllowedController)($this->context);
        }

        return json_encode(
            $this->context->getResponse()
        );
    }
}
