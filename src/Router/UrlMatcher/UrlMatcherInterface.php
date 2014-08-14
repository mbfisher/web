<?php

namespace mbfisher\Web\Router\UrlMatcher;

interface UrlMatcherInterface
{
    public function match($template, $path);
}
