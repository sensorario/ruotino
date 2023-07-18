<?php

namespace App;

class NotAllowedController implements Command
{
    public function __invoke($context)
    {
        $context->setResponse([
            'code' => 405,
            'message' => 'Not Allowed'
        ]);
    }
}
