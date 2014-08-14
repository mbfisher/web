<?php

namespace mbfisher\Web\Router;

use mbfisher\Web\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    public function add(RouteInterface $route);

    /**
     * @return RouteInterface
     */
    public function run(Request $request);
}
