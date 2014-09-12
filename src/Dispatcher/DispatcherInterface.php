<?php

namespace mbfisher\Web\Dispatcher;

use Symfony\Component\HttpFoundation\Request;
use mbfisher\Web\Dispatcher\Context;

interface DispatcherInterface
{
    /**
     * @return Response
     */
    public function dispatch(Request $request, Context $context);
}
