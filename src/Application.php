<?php

namespace mbfisher\Web;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use mbfisher\Web\Router\RouterInterface;
use mbfisher\Web\Dispatcher\DispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use mbfisher\Web\Exception\Routing\RoutingFailureException;
use mbfisher\Web\Exception\Routing\MethodNotAllowedException;

class Application implements HttpKernelInterface
{
    public function __construct(
        RouterInterface $router,
        DispatcherInterface $dispatcher
    ) {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    public function handle(
        Request $request,
        $type = self::MASTER_REQUEST,
        $catch = true
    ) {
        try {
            $context = $this->getRouter()->run($request);
            return $this->getDispatcher()->dispatch($request, $context);
        } catch (Exception $ex) {
            throw $ex;
            if ($ex instanceof RoutingFailureException) {
                return $this->handleRoutingFailure($request, $ex);
            }

            if ($catch) {
                return $this->handleException($request, $ex);
            } else {
                throw $ex;
            }
        }
    }

    public function handleRoutingFailure(Request $request, RoutingFailureException $ex)
    {
        switch (true) {
            case $ex instanceof MethodNotAllowedException:
                return new Response($ex->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED, [
                    'Allow' => $ex->getAllowedMethods()
                ]);
                break;
            default:
                return new Response($ex->getMessage(), Response::HTTP_NOT_FOUND);
                break;
        }
    }

    public function handleException(Request $request, Exception $ex)
    {
        return new Response($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
