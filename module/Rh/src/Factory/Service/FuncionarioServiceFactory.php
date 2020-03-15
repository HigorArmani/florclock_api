<?php

namespace Rh\Factory\Service;

use Base\Factory\Service\AbstractServiceFactory;
use Rh\Service\FuncionarioService;

class FuncionarioServiceFactory extends AbstractServiceFactory
{
    protected $service = FuncionarioService::class;

}