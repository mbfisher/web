<?php

namespace mbfisher\Web\Route;

interface RouteCollectionInterface
{
    /**
     * @return RouteInterface[]
     */
    public function getRoutes();
}
