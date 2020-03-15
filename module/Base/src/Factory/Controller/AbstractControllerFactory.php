<?php

namespace Base\Factory\Controller;

use Interop\Container\ContainerInterface;

abstract class AbstractControllerFactory
{
    protected $controller;
    protected $service;

    public function __invoke(ContainerInterface $container)
    {
        $em         = $container->get('doctrine.entitymanager.orm_default');
        $apiService = $container->get(\Base\ApiService::class);
        $service    = $container->get($this->service);

        return new $this->controller($em, $apiService, $service);
    }
}