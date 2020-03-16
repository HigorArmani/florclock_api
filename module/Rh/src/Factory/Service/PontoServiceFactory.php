<?php

namespace Rh\Factory\Service;

use Base\Factory\Service\AbstractServiceFactory;
use Rh\Service\PontoService;
use Interop\Container\ContainerInterface;

class PontoServiceFactory extends AbstractServiceFactory
{
    protected $service = PontoService::class;

    public function __invoke(ContainerInterface $container)
    {
        $em          = $container->get('doctrine.entitymanager.orm_default');
        $funcService = $container->get(\Rh\FuncionarioService::class);

        return new $this->service($em, $funcService);
    }
}