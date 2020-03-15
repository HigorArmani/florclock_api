<?php

namespace Rh\Factory\Controller;

use Base\Factory\Controller\AbstractControllerFactory;

use Rh\Controller\EscalasController;

class EscalasControllerFactory extends AbstractControllerFactory
{

    protected $controller = EscalasController::class;
    protected $service    = \Rh\EscalaService::class;
    
}