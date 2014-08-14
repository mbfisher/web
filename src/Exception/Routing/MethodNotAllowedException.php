<?php

namespace mbfisher\Web\Exception\Routing;

class MethodNotAllowedException extends RoutingFailureException
{
    private $method;
    private $path;
    private $allowed;

    public function __construct($method, $path, array $allowed = [])
    {
        $this->method = $method;
        $this->path = $path;
        $this->allowed = $allowed;

        parent::__construct("Method $method not allowed for $path");
    }
}
