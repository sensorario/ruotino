<?php

namespace App\Tests;

use App\Command;
use App\ControllerFactory;
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

    /** @test */
    public function catchAlsoDynamicRoutes()
    {
        $factory = new ControllerFactory([
            '/foo/:bar' => ExistingController::class,
            '/fizz/fuzz/sprazz/:buzz' => WrongCongtroller::class,
            '/fizz/:buzz' => AnotherCongtroller::class,
        ]);
        $controller = $factory->getController('/fizz/ciaone');
        $this->assertInstanceOf(AnotherCongtroller::class, $controller);
    }
}

class ExistingController implements Command {}
class AnotherCongtroller implements Command {}
class WrongCongtroller implements Command {}
