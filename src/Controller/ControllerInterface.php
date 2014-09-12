<?php

namespace mbfisher\Web\Controller;

use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    public function options(Request $request, array $variables = []);
}
