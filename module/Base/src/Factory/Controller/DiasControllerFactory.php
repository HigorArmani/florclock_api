<?php

namespace Base\Factory\Controller;

use Base\Factory\Controller\AbstractControllerFactory;

use Base\Controller\DiasController;

class DiasControllerFactory extends AbstractControllerFactory
{

    protected $controller = DiasController::class;
    protected $service    = \Base\DiaService::class;
    
}