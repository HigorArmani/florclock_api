<?php

namespace Rh\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class FuncionariosController extends AbstractController
{

    protected $entity = "Rh\Entity\Funcionario";
    protected $groups = ["RhFuncionario"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
    }
}