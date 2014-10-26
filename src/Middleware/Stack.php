<?php

namespace mbfisher\Web\Middleware;

use SplStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Stack extends SplStack
{
    public function push($factory)
    {
        if (!is_callable($factory)) {
            throw new \InvalidArgumentException("Middleware factory must be callable");
        }

        parent::push($factory);
        return $this;
    }

    public function resolve(HttpKernelInterface $app)
    {
        foreach ($this as $factory) {
            $app = call_user_func($factory, $app);
        }

        return $app;
    }
}
