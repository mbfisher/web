<?php

namespace mbfisher\Web\Router;

use mbfisher\Web\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

interface RouterInterface
{
    public function addRoute(RouteInterface $route);
    public function addCollection(RouteCollectionInterface $collection);

    /**
     * @return RouteInterface
     */
    public function run(Request $request);
}
