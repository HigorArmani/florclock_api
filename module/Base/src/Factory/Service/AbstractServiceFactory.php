<?php

namespace Base\Factory\Service;

use Interop\Container\ContainerInterface;

abstract class AbstractServiceFactory
{
    protected $service;

    public function __invoke(ContainerInterface $container)
    {

        $em = $container->get('doctrine.entitymanager.orm_default');

        return new $this->service($em);
    }
}