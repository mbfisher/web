<?php

namespace mbfisher\Web\Exception\Routing;

class RouteNotFoundException extends RoutingFailureException
{
    private $method;
    private $path;

    public function __construct($method, $path)
    {
        $this->method = $method;
        $this->path = $path;

        parent::__construct("No route found for $method $path");
    }
}
