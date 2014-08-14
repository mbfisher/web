<?php

namespace mbfisher\Web\Route;

interface RouteInterface
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    public function getMethod();
    public function getPattern();
    public function getHandler();
}
