<?php

namespace mbfisher\Web\Router;

use mbfisher\Web\Route\RouteInterface;
use mbfisher\Web\Router\UrlMatcher\UrlMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Exception\Routing\MethodNotAllowedException;
use mbfisher\Web\Exception\Routing\RouteNotFoundException;
use mbfisher\Web\Dispatcher\Context;

class Router implements RouterInterface
{
    private $matcher;
    private $handlers = [];
    private $methods = [];

    public function __construct(UrlMatcherInterface $matcher)
    {
        $this->matcher = $matcher;

        $this->configure();
    }

    protected function configure()
    {
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getMatcher()
    {
        return $this->matcher;
    }

    public function addRoute(RouteInterface $route)
    {
        $pattern = $route->getPattern();
        $method = $route->getMethod();
        $handler = $route->getHandler();

        $this->handlers[$pattern] = $handler;

        if (!isset($this->methods[$handler])) {
            $this->methods[$handler] = [];
        }

        $this->methods[$handler] += [$method];

        return $this;
    }

    public function addCollection(RouteCollectionInterface $collection)
    {
        foreach ($collection->getRoutes() as $route) {
            $this->addRoute($route);
        }

        return $this;
    }

    public function run(Request $request)
    {
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        foreach ($this->handlers as $pattern => $handler) {
            if (false === $variables = $this->matcher->match($pattern, $path)) {
                continue;
            }

            if (in_array($method, $this->methods[$handler])) {
                return new Context($handler, $variables);
            } else {
                throw new MethodNotAllowedException($method, $path, $this->methods[$handler]);
            }
        }

        throw new RouteNotFoundException($method, $path);
    }
}
