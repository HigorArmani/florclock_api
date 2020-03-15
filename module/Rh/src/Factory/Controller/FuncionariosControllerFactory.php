<?php

namespace Rh\Factory\Controller;

use Base\Factory\Controller\AbstractControllerFactory;

use Rh\Controller\FuncionariosController;

class FuncionariosControllerFactory extends AbstractControllerFactory
{

    protected $controller = FuncionariosController::class;
    protected $service    = \Rh\FuncionarioService::class;
    
}