<?php

namespace App;

/** @codeCoverageIgnore */
class MondoneController implements Command
{
    public function get(RequestContext $context)
    {
        $context->setResponse([
            'code' => 200,
            'message' => 'OK',
            'data' => $context->getData(),
        ]);
    }
}
