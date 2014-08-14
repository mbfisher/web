<?php

namespace mbfisher\Web\Controller;

interface ControllerInterface
{
    public function getAllowedMethods();
    public function options(Request $request, array $variables = []);
}
