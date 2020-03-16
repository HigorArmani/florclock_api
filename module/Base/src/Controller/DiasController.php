<?php

namespace Base\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class DiasController extends AbstractController
{

    protected $entity = "Base\Entity\Dia";
    protected $groups = ["BaseDia"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
    }
}