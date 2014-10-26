<?php

namespace mbfisher\Web\Middleware;

use Symfony\Component\HttpKernel\HttpKernelInterface;

abstract class Middleware implements HttpKernelInterface
{
    private $kernel;

    public function __construct(HttpKernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getKernel()
    {
        return $this->kernel;
    }
}
