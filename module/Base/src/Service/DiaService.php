<?php

namespace Base\Service;

use Doctrine\ORM\EntityManagerInterface;
use Base\Service\AbstractService;

class DiaService extends AbstractService
{
    /**
     *
     * @var type String
     */
    protected $entity = "Base\Entity\Dia";

    /**
     * 
     * @param EntityManagerInterface $em
     * @param String $entity
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }
}