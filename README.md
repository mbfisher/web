```php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use mbfisher\Web\Router\Router;
use mbfisher\Web\Router\UrlMatcher\UrlMatcher;
use mbfisher\Web\Route\Route;
use mbfisher\Web\Dispatcher\ClosureDispatcher;

$router = new Router(new UrlMatcher);
$router->add(new Route('GET', '/', 'example'));

$dispatcher = new ClosureDispatcher([
    'example' => function () {
        return new Response;
    }
]);

$app = new Application($router, $dispatcher);

$request = Request::create('/', 'GET');
$response = $app->handle($request);

$response->send();
```
