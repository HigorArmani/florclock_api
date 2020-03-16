<?php

namespace Rh\Service;

use Doctrine\ORM\EntityManagerInterface;
use Base\Service\AbstractService;

class EscalaService extends AbstractService
{
    /**
     *
     * @var type String
     */
    protected $entity = "Rh\Entity\Escala";

    /**
     * 
     * @param EntityManagerInterface $em
     * @param String $entity
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    /**
     *
     * @param array $data
     * @return \Base\Service\entity
     */
    public function insert(array $data)
    {
        foreach($data['rhHorarios'] as $d) {
            $entity = new $this->entity($d);

            $entity->setNome($data["nome"]);
           // $entity->setBaseDia($this->em->getReference("Base\Entity\Dia", $d["baseDia"]["id"]));

            $this->em->persist($entity);
            $this->em->flush();

            $result['id'][] = $entity->getId();
        }
        
        return $result;
    }
}