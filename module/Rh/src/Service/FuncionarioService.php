<?php

namespace Rh\Service;

use Doctrine\ORM\EntityManagerInterface;
use Base\Service\AbstractService;
use Zend\Hydrator\ClassMethods;

class FuncionarioService extends AbstractService
{
    const AUSENTE = 1;

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

   /**
     *
     * @param array $data
     * @return \Base\Service\entity
     */
    public function insert(array $data)
    {
        $entity = new $this->entity($data);

        $entity->setRhEscala(
            $this->em->getReference("Rh\Entity\Escala", 1) // Exemplo
        );
        
        $entity->setRhFuncionarioStatus(
            $this->em->getReference("Rh\Entity\FuncionarioStatus", self::AUSENTE) // Exemplo
        );

        $entity->setHrSaldo(0);
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
    
   /**
     *
     * @param int $id
     * @param array $data
     * @return type
     */
    public function update(int $id, array $data)
    {
        unset($data["rhEscala"]);
        $entity = $this->em->getReference($this->entity, $id);

        $hydrator = new ClassMethods;
        $hydrator->hydrate($data, $entity);

        if(isset($data["rhFuncionarioStatus"]["id"])) {
            $entity->setRhFuncionarioStatus(
                $this->em->getReference("Rh\Entity\FuncionarioStatus", $data["rhFuncionarioStatus"]["id"]) // Exemplo
            );
        }

        $entity->setHrSaldo(random_int(0,120));

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    // Calcular saldo
   /* private function calcSaldo($id) {

        $pontos = $this->em
            ->getRepository("Rh\Entity\Ponto")
            ->findByRhFuncionario($id);

        $hr = 0;
        foreach($pontos as $ponto) {
            $horasM = $ponto->getHrEntrada() - $ponto->getHrEntradaAlmoço();
            $horasT = $ponto->getHrSaidaAlmoco() - $ponto->getHrSaida();
            
            $hr += $horasM + $horasT;
        }

        $horasAPagar = 8 * 66;
    } */
}