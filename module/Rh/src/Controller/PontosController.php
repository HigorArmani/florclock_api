<?php

namespace Rh\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class PontosController extends AbstractController
{

    protected $entity = "Rh\Entity\Ponto";
    protected $groups = ["RhPonto"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
    }
}