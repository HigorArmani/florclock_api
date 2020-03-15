<?php

namespace Auth\Factory\Controller;

use Auth\Controller\LoginController;
use Interop\Container\ContainerInterface;

class LoginControllerFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get(\Auth\AuthAdapter::class);
        return new LoginController($adapter);
    }
}
