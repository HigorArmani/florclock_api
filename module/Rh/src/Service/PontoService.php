<?php

namespace Rh\Service;

use Doctrine\ORM\EntityManagerInterface;
use Base\Service\AbstractService;
use Rh\Service\FuncionarioService;
use Zend\Hydrator\ClassMethods;

class PontoService extends AbstractService
{
    const AUSENTE = 1;
    const TRABALHANDO = 2;
    const ALMOCANDO = 3;
    /**
     *
     * @var type String
     */
    protected $entity = "Rh\Entity\Ponto";

    /**
     *
     * @var type FuncionarioService
     */
    private $funcionarioService;

    /**
     * 
     * @param EntityManagerInterface $em
     * @param String $entity
     */
    public function __construct(EntityManagerInterface $em, FuncionarioService $funcionarioService)
    {
        parent::__construct($em);
        $this->funcionarioService = $funcionarioService;
    }

    /**
     *
     * @param array $data
     * @return \Base\Service\entity
     */
    public function insert(array $data)
    {
        $idFunc = $data["rhFuncionario"]["id"];

        $entity = new $this->entity($data);

        $entity->setRhFuncionario(
            $this->em->getReference("Rh\Entity\Funcionario", $idFunc)
        );

        $this->em->persist($entity);
        $this->em->flush();
        
        $this->updateFuncInfo($entity->getRhFuncionario()->getId());

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
        unset($data["rhFuncionario"]);
        $entity = $this->em->getReference($this->entity, $id);

        $hydrator = new ClassMethods;
        $hydrator->hydrate($data, $entity);

        $this->em->persist($entity);
        $this->em->flush();
        
        $this->updateFuncInfo($entity->getRhFuncionario()->getId());

        return $entity;
    }
    
        // o certo é ficar no repository
    private function getLastPontoByFunc($idFunc){
       $ponto = $this->em
            ->getRepository("Rh\Entity\Ponto")
            ->findOneBy(["rhFuncionario" => $idFunc], ["data" => "DESC"]);
       
       $status = self::AUSENTE;
       $hora = null;
       if($ponto->getHrEntrada()) {
           $hora = $ponto->getHrEntrada();
           $status = self::TRABALHANDO;
       }
       
       if($ponto->getHrEntradaAlmoco()) {
           $hora = $ponto->getHrEntradaAlmoco();
           $status = self::ALMOCANDO;
       }
       
       if($ponto->getHrSaidaAlmoco()) {
           $hora = $ponto->getHrSaidaAlmoco();
          $status = self::TRABALHANDO;
       }
       
       if($ponto->getHrSaida()) {
           $hora = $ponto->getHrSaida();
           $status = self::AUSENTE;
       }

       return ['hora' => $hora, 'status' => $status];
    }
    
    private function updateFuncInfo($idFunc){
        
        $lastPonto = $this->getLastPontoByFunc($idFunc);
        
        $funcData = [
            "rhFuncionarioStatus" => [
                "id" => $lastPonto['status']
            ],
            "hrUltima" => $lastPonto['hora']
        ];
        
        $this->funcionarioService->update($idFunc, $funcData);
    }
}