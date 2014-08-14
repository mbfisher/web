<?php

namespace mbfisher\Web\Router;

use mbfisher\Web\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Route\Context;
use mbfisher\Web\Exception\Routing\RouteNotFoundException;

class PathRouter extends Router implements RouterInterface
{
    public function add(RouteInterface $route)
    {
        $pattern = $route->getPattern();
        $this->routes[$patter] = $route->getHandler();

        return $this;
    }

    public function run(Request $request)
    {
        $path = $request->getPathInfo();

        foreach ($this->routes as $pattern => $handler) {
            if (false !== $variables = $this->matcher->match($pattern, $path)) {
                return new Context($handler, $variables);
            }
        }

        throw new RouteNotFoundException($method, $path);
    }
}
