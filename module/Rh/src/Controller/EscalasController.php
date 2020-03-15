<?php

namespace Rh\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class EscalasController extends AbstractController
{

    protected $entity = "Rh\Entity\Escala";
    protected $groups = ["RhEscala"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
    }
}