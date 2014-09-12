<?php

namespace mbfisher\Web\Dispatcher;

use mbfisher\Web\Controller\ControllerFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Route\Context;
use mbfisher\Web\Route\RouteInterface;
use mbfisher\Web\Exception\ROuting\MethodNotAllowedException;

/**
 * Dispatches to controller objects whose method names map to HTTP request
 * methods.
 */
class ControllerDispatcher implements DispatcherInterface
{
    private $factory;

    public function __construct(ControllerFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function dispatch(Request $request, Context $context)
    {
        $handler = $context->getHandler();
        list($handler, $action) = $this->extractComponents($handler, $request);

        $controller = $this->getFactory()->build($handler);
        $variables = $context->getVariables();

        if (!method_exists($method, $controller)) {
            throw new RoutingFailedException("Method $method not found on handler $handler");
        }

        return call_user_func([$controller, strtolower($method)], $request, $variables);
    }

    protected function extractComponents($handler, Request $request)
    {
        $components = explode(':', $handler, 2);

        if (count($components) === 1) {
            $method = $request->getMethod();
            $components = [$handler, strtolower($method)];
        }

        return $components;
    }
}
