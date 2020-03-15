<?php

namespace Rh;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {

    }

    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                FuncionarioService::class => Factory\Service\FuncionarioServiceFactory::class,
                PontoService::class => Factory\Service\PontoServiceFactory::class,
                HorarioService::class => Factory\Service\HorarioServiceFactory::class,
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                FuncionariosController::class => Factory\Controller\FuncionariosControllerFactory::class,
                PontosController::class => Factory\Controller\PontosControllerFactory::class,
                HorariosController::class => Factory\Controller\HorariosControllerFactory::class,
            ]
        ];
    }
}