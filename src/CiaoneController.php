<?php

namespace App;

class CiaoneController implements Command
{
    public function get($context)
    {
        $context->setResponse([
            'code' => 200,
            'message' => 'OK'
        ]);
    }
}
