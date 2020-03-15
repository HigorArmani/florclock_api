<?php

namespace Auth\Auth;

use Doctrine\ORM\EntityManager;

class Adapter
{
    protected $em;
    protected $email;
    protected $senha;
    private $payload;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getEmail()
    {
        return $this->email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function isValid()
    {
        $repository = $this->em->getRepository("Auth\Entity\Usuario");
        $usuario = $repository->findCredential($this->getEmail(), $this->getSenha());
        
        if (!$usuario) {
            return false;
        } else {
            $this->payload = $usuario;
            return true;
        }
    }

    public function getPayload()
    {
        if ($this->payload) {
            return $this->payload;
        }

        return false;
    }
}
