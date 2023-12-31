<?php

namespace App;


/** @codeCoverageIgnore */
class RequestContext
{
    public function __construct(
        private array $response = [],
        private $server = new Server,
    ) { }

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
        return $this->server->getDefaults()['REQUEST_URI'];
    }

    public function method()
    {
        return strtolower($this->server->getDefaults()['REQUEST_METHOD']);
    }
}

