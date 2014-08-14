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
    protected $routes;

    public function __construct(UrlMatcherInterface $matcher, array $routes = [])
    {
        $this->matcher = $matcher;
        $this->routes = $routes;
        $this->configure();
    }

    protected function configure()
    {
    }

    public function add(RouteInterface $route)
    {
        $method = $route->getMethod();

        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $pattern = $route->getPattern();
        $this->routes[$method][$pattern] = $route->getHandler();

        return $this;
    }

    public function run(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPathInfo();

        if (!isset($this->routes[$method])) {
            throw new MethodNotAllowedException($method, $path, array_keys($this->routes));
        }

        foreach ($this->routes[$method] as $pattern => $handler) {
            if (false !== $variables = $this->matcher->match($pattern, $path)) {
                return new Context($handler, $variables);
            }
        }

        throw new RouteNotFoundException($method, $path);
    }
}
