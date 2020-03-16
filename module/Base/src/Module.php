<?php

namespace Base;

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
                ApiService::class => Factory\Service\ApiServiceFactory::class,      
                DiaService::class => Factory\Service\DiaServiceFactory::class,
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                DiasController::class => Factory\Controller\DiasControllerFactory::class,
            ]
        ];
    }
}