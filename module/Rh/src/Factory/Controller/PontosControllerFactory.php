<?php

namespace Rh\Factory\Controller;

use Base\Factory\Controller\AbstractControllerFactory;

use Rh\Controller\PontosController;

class PontosControllerFactory extends AbstractControllerFactory
{

    protected $controller = PontosController::class;
    protected $service    = \Rh\PontoService::class;
    
}