<?php

namespace mbfisher\Web\Dispatcher;

use Symfony\Component\HttpFoundation\Request;

class Context
{
    private $handler;
    private $variables;

    public function __construct($handler, array $variables = [])
    {
        $this->handler = $handler;
        $this->variables = $variables;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function __invoke(callable $controller, Request $request)
    {
        return call_user_func($controller, $request, $this->getVariables());
    }
}
