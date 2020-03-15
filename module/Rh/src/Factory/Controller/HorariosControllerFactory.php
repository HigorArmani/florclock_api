<?php

namespace Rh\Factory\Controller;

use Base\Factory\Controller\AbstractControllerFactory;

use Rh\Controller\HorariosController;

class HorariosControllerFactory extends AbstractControllerFactory
{

    protected $controller = HorariosController::class;
    protected $service    = \Rh\HorarioService::class;
    
}