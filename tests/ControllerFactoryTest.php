<?php

namespace App\Tests;

use App\Command;
use App\ControllerFactory;
use App\BadRequestController;
use App\RequestContext;
use PHPUnit\Framework\TestCase;

class ControllerFactoryTest extends TestCase
{
    /** @test */
    public function returnBadRequestIfNoRoutesAreDefinedAndControllerIsStillRequested()
    {
        $factory = new ControllerFactory;
        $controller = $factory->getController('not exists', new RequestContext());
        $this->assertInstanceOf(BadRequestController::class, $controller);
    }

    /** @test */
    public function acceptRoutesViaConstructor()
    {
        $factory = new ControllerFactory([
            'exists' => ExistingController::class,
        ]);
        $controller = $factory->getController('exists', new RequestContext());
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
        $controller = $factory->getController('/fizz/ciaone', new RequestContext());
        $this->assertInstanceOf(AnotherCongtroller::class, $controller);
    }

    /** @test */
    public function catchAlsoComplexDynamicRoutes()
    {
        $this->markTestSkipped();
        $factory = new ControllerFactory([
            '/fizz/:buzz/wrong' => WrongCongtroller::class,
            '/fizz/:buzz/another' => AnotherCongtroller::class,
        ]);
        $controller = $factory->getController('/fizz/ciaone/another', new RequestContext());
        $this->assertInstanceOf(AnotherCongtroller::class, $controller);
    }
}

class ExistingController implements Command {}
class AnotherCongtroller implements Command {}
class WrongCongtroller implements Command {}
