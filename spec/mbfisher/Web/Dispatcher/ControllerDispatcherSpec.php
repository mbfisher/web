<?php

namespace spec\mbfisher\Web\Dispatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use mbfisher\Web\Controller\ControllerFactoryInterface;
use mbfisher\Web\Dispatcher\Context;
use mbfisher\Web\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ControllerDispatcherSpec extends ObjectBehavior
{
    function let(ControllerFactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('mbfisher\Web\Dispatcher\ControllerDispatcher');
    }

    function it_dispatches_with_default_action(
        ControllerFactoryInterface $factory,
        Context $context,
        ControllerInterface $controller,
        Response $response
    ) {
        $request = Request::create('/', 'OPTIONS');

        $context->getHandler()->willReturn('test');
        $context->getVariables()->willReturn(['foo']);

        $factory->build('test')->willReturn($controller);
        $controller->options($request, ['foo'])->willReturn($response);

        $this->dispatch($request, $context)->shouldReturn($response);
    }

    function it_dispatches_with_declared_action(
        ControllerFactoryInterface $factory,
        Context $context,
        ControllerInterface $controller,
        Response $response
    ) {
        $request = Request::create('/', 'OPTIONS');

        $context->getHandler()->willReturn('test');
        $context->getVariables()->willReturn(['foo']);

        $factory->build('test')->willReturn($controller);
        $controller->options($request, ['foo'])->willReturn($response);

        $this->dispatch($request, $context)->shouldReturn($response);
    }
}
