<?php

namespace mbfisher\Web\Dispatcher;

use Symfony\Component\HttpFoundation\Request;

interface DispatcherInterface
{
    /**
     * @return Response
     */
    public function dispatch(Request $request, Context $context);
}
