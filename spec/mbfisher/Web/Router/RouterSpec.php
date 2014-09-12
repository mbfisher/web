<?php

namespace spec\mbfisher\Web\Router;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use mbfisher\Web\Router\UrlMatcher\UrlMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Route\RouteInterface;
use mbfisher\Web\Exception\Routing\MethodNotAllowedException;
use mbfisher\Web\Exception\Routing\RouteNotFoundException;

class RouterSpec extends ObjectBehavior
{
    function let(UrlMatcherInterface $matcher)
    {
        $this->beConstructedWith($matcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('mbfisher\Web\Router\Router');
    }

    function it_matches_a_route(RouteInterface $route, UrlMatcherInterface $matcher)
    {
        $route->getPattern()->willReturn('/foo');
        $route->getMethod()->willReturn('GET');
        $route->getHandler()->willReturn('bar');

        $this->addRoute($route);

        $request = Request::create('/foo', 'GET');
        $matcher->match('/foo', '/foo')->willReturn([]);

        $context = $this->run($request);
        $context->getHandler()->shouldReturn('bar');
        $context->getVariables()->shouldReturn([]);
    }

    function it_throws_route_not_found(RouteInterface $route, UrlMatcherInterface $matcher)
    {
        $route->getPattern()->willReturn('/foo');
        $route->getMethod()->willReturn('GET');
        $route->getHandler()->willReturn('bar');

        $this->addRoute($route);

        $request = Request::create('/baz', 'GET');
        $matcher->match('/foo', '/baz')->willReturn(false);

        $ex = new RouteNotFoundException('GET', '/baz');
        $this->shouldThrow($ex)->duringRun($request);
    }

    function it_throws_method_not_allowed(RouteInterface $route, UrlMatcherInterface $matcher)
    {
        $route->getPattern()->willReturn('/foo');
        $route->getMethod()->willReturn('POST');
        $route->getHandler()->willReturn('bar');

        $this->addRoute($route);

        $request = Request::create('/foo', 'GET');
        $matcher->match('/foo', '/foo')->willReturn([]);

        $ex = new MethodNotAllowedException('GET', '/foo', ['POST']);
        $this->shouldThrow($ex)->duringRun($request);
    }

    function it_throws_route_not_found_when_empty()
    {
        $ex = 'mbfisher\Web\Exception\Routing\RouteNotFoundException';
        $request = new Request;
        $this->shouldThrow($ex)->duringRun($request);
    }
}
