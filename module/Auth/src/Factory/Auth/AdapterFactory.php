<?php

namespace Auth\Factory\Auth;

use Interop\Container\ContainerInterface;

use Auth\Auth\Adapter;

class AdapterFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');

        return new Adapter($em);
    }
}