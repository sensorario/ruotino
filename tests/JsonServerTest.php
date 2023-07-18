<?php

namespace App\Tests;

use App\Command;
use App\ControllerFactory;
use App\JsonServer;
use App\RequestContext;
use App\Server;
use App\BadRequestController;
use PHPUnit\Framework\TestCase;

class JsonServerTest extends TestCase
{
    private RequestContext $context;
    private Server $server;

    private ControllerFactory $factory;

    public function setUp(): void
    {
        $this->context = $this
            ->getMockBuilder(RequestContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->server = $this
            ->getMockBuilder(Server::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = $this
            ->getMockBuilder(ControllerFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @test */
    public function return404NotFoundWheneverNoRoutesAreDefined()
    {
        $this->context->expects($this->once())->method('action')->willReturn('/');
        $this->context->expects($this->once())->method('method')->willReturn('get');
        $this->factory->expects($this->once())->method('getController')->with('/')->willReturn(new BadRequestController);
        $this->context->expects($this->once())->method('setResponse')->with([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        $this->context->expects($this->once())->method('getResponse')->willReturn([
            'code' => 404,
            'message' => 'Not Found'
        ]);

        $server = new JsonServer(
            $this->context,
            $this->factory,
        );

        $this->assertEquals('{"code":404,"message":"Not Found"}', $server());
    }

    /** @test */
    public function return405NotAllowedWheneverRouteExistsButNotMethodRequested()
    {
        $this->context->expects($this->once())->method('action')->willReturn('/foo');
        $this->context->expects($this->once())->method('method')->willReturn('post');
        $this->factory->expects($this->once())->method('getController')->with('/foo')->willReturn(new BadRequestController);
        $this->context->expects($this->once())->method('setResponse')->with([
            'code' => 405,
            'message' => 'Not Allowed'
        ]);
        $this->context->expects($this->once())->method('getResponse')->willReturn([
            'code' => 405,
            'message' => 'Not Allowed'
        ]);

        $server = new JsonServer(
            $this->context,
            $this->factory,
        );

        $this->assertEquals('{"code":405,"message":"Not Allowed"}', $server());
    }
}

class FakeController implements Command
{
    public function get($context)
    {
        $context->setResponse([
            'code' => 200,
            'message' => 'OK'
        ]);
    }
}
