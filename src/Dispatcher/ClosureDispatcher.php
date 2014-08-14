<?php

namespace mbfisher\Web\Dispatcher;

use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Dispatcher\Context;

class ClosureDispatcher implements DispatcherInterface
{
    protected $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function dispatch(Request $request, Context $context)
    {
        $handler = $context->getHandler();

        if (!isset($this->handlers[$handler])) {
            throw new Exception;
        }

        return $context($this->handlers[$handler], $request);
    }
}
