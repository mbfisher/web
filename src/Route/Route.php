<?php

namespace mbfisher\Web\Route;

class Route implements RouteInterface
{
    private $method;
    private $pattern;
    private $handler;

    public function __construct($method, $pattern, $handler)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->handler = $handler;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function getPattern()
    {
        return $this->pattern;
    }
    
    public function getHandler()
    {
        return $this->handler;
    }
}
