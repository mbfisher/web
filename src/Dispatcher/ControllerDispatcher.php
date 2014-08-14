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
        $controller = $this->getFactory()->build($handler);

        $method = $request->getMethod();
        $variables = $context->getVariables();

        if ($method === RouteInterface::METHOD_OPTIONS) {
            return $controller->options($request, $variables);
        }

        $allowed = $controller->getAllowedMethods();
        if (!in_array($method, $allowed)) {
            throw new MethodNotAllowedException($allowed);
        }

        return call_user_func([$controller, strtolower($method)], $request, $variables);
    }
}
