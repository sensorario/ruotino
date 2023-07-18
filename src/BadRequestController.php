<?php

namespace App;

class BadRequestController implements Command
{
    public function get($context)
    {
        $context->setResponse([
            'code' => 404,
            'message' => 'Not Found'
        ]);
    }
}
