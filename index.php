<?php

// command: azione da eseguire
// client: chi istanzia il command
// invoker: invoca il comando
// receiver: esegue azioni legate ad un comando

interface Command {
    public function run(array $context);
}

// receiver
class RequestContext
{
    public function __construct(
        private array $response = [],
        private array $params = [],
    ) {
        $this->params = $_SERVER;
    }

    public function setResponse(array $response)
    {
        $this->response = $response;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function action()
    {
        return $this->params['REQUEST_URI'];
    }
}

class BadRequestController implements Command
{
    public function run($context)
    {
        $context->setResponse([
            'code' => 404,
            'message' => 'Bad Request'
        ]);
    }
}

class CiaoneController implements Command
{
    public function run($context)
    {
        $context->setResponse([
            'code' => 200,
            'message' => 'OK'
        ]);
    }
}

class ControllerFactory
{
    public static function getController(string $actin): Command
    {
        return match($actin) {
            '/ciaone' => new CiaoneController,
            default => new BadRequestController,
        };
    }
}

// client | invoker
class JsonServer
{
    public function __construct(
        private RequestContext $context = new RequestContext,
        private ControllerFactory $factory = new ControllerFactory,
    ) { }

    public function __invoke()
    {
        $action = $this->context->action();

        $controller = $this->factory::getController($action);
        $controller->run($this->context);

        echo json_encode(
            $this->context->getResponse()
        );
    }
}

(new JsonServer)();