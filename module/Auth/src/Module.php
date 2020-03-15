<?php

namespace Auth;

use Zend\Uri\UriFactory;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;

class Module implements ControllerProviderInterface, ServiceProviderInterface
{

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri');
        $events    = $e->getApplication()->getEventManager();
        $aggregate = new Listener\Aggregate;

        $aggregate->attach($events);
    }

    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }

    public function getServiceConfig()
    {

        return [
            'factories' => [
                AuthAdapter::class => Factory\Auth\AdapterFactory::class,
                UsuarioService::class => Factory\Service\UsuarioServiceFactory::class,
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                LoginController::class => Factory\Controller\LoginControllerFactory::class,
            ]
        ];
    }
}