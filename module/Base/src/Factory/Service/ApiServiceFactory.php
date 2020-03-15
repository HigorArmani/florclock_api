<?php

namespace Base\Factory\Service;

use Base\Factory\Service\AbstractServiceFactory;
use Base\Service\ApiService;

class ApiServiceFactory extends AbstractServiceFactory
{
    protected $service = ApiService::class;

}