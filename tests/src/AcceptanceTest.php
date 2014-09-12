<?php

namespace mbfisher\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use mbfisher\Web\Router\Router;
use mbfisher\Web\Router\UrlMatcher\UrlMatcher;
use mbfisher\Web\Route\Route;
use mbfisher\Web\Dispatcher\ClosureDispatcher;

class AcceptanceTest extends \PHPUnit_Framework_TestCase
{
    public function testApp()
    {
        $request = Request::create('/', 'GET');
        $response = new Response;

        $router = new Router(new UrlMatcher);
        $router->addRoute(new Route('GET', '/', 'test'));

        $dispatcher = new ClosureDispatcher([
            'test' => function () use ($response) {
                return $response;
            }
        ]);

        $app = new Application($router, $dispatcher);

        $result = $app->handle($request);
        $this->assertSame($response, $result);
    }
}
