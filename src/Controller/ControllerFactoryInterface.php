<?php

namespace mbfisher\Web\Controller;

interface ControllerFactoryInterface
{
    /**
     * @return ControllerInterface
     */
    public function build($handler);
}
