<?php

namespace Rh\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class HorariosController extends AbstractController
{

    protected $entity = "Rh\Entity\Horario";
    protected $groups = ["RhHorario"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
    }
}