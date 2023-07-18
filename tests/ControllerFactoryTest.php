<?php

namespace App\Tests;

use App\Command;
use App\ControllerFactory;
use App\JsonServer;
use App\RequestContext;
use App\Server;
use App\BadRequestController;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{
    /** @test */
    public function returnBadRequestIfNoRoutesAreDefinedAndControllerIsStillRequested()
    {
        $factory = new ControllerFactory;
        $controller = $factory->getController('not exists');
        $this->assertInstanceOf(BadRequestController::class, $controller);
    }

    /** @test */
    public function acceptRoutesViaConstructor()
    {
        $factory = new ControllerFactory([
            'exists' => ExistingController::class,
        ]);
        $controller = $factory->getController('exists');
        $this->assertInstanceOf(ExistingController::class, $controller);
    }
}

class ExistingController implements Command {}
