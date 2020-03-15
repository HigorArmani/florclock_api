<?php

namespace Rh\Service;

use Doctrine\ORM\EntityManagerInterface;
use Base\Service\AbstractService;

class FuncionarioService extends AbstractService
{
    /**
     *
     * @var type String
     */
    protected $entity = "Rh\Entity\Funcionario";

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