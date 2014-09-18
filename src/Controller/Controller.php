<?php

namespace mbfisher\Web\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller implements ControllerInterface
{
    public function options(Request $request, array $variables = [])
    {
        $response = new Response;
        $response->headers->set('Allow', implode(', ', []));

        return $response;
    }
}
