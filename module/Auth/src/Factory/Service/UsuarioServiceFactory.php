<?php

namespace Auth\Factory\Service;

use Interop\Container\ContainerInterface;
use Auth\Service\Usuario;

class UsuarioServiceFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');

        $headers = $container->get('Request')->getHeaders()->get('Authorization');
        $auth = false;
        if ($headers) {
            $auth = $headers->getFieldValue();
        }

        $authorization = str_replace('Bearer ', '', $auth);

        return new Usuario($em, $authorization);
    }
}
