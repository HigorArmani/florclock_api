<?php

namespace Auth\Service;

use Zend\Hydrator\ClassMethods;
use Doctrine\ORM\EntityManager;
use Auth\Auth\Token;

class Usuario
{

    private $authorization;
    protected $em;
    protected $entity = 'Auth\Entity\Usuario';

    /**
     *
     * @param EntityManager $em
     * @param \Auth\Service\String $authorization
     */
    public function __construct(EntityManager $em, String $authorization)
    {
        $this->authorization = $authorization;
        $this->em            = $em;
    }

    function getUsuario()
    {
        if ($this->authorization) {
            $data = Token::getValidPayload($this->authorization);

            $qb = $this->em->getRepository($this->entity)
                ->createQueryBuilder('u');

            $qb->select('u.id');
            $qb->addSelect('u.nome');

            $qb->where($qb->expr()->eq('u.email', ':email'));
            $qb->setParameter('email', $data['email']);

            $qb->setMaxResults(1);

            return $qb->getQuery()->getOneOrNullResult();
        }

        exit;
    }
 
}