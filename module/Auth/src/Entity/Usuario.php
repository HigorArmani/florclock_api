<?php

namespace Auth\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use JMS\Serializer\Annotation as JMS;

/**
 * Usuario
 *
 * @ORM\Table(name="auth_usuario")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Auth\Entity\UsuarioRepository")
 */
class Usuario
{
    /**
     *
     * @var integer
     *
     * @ORM\Column(name="id_auth_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=true)
     */
    private $email;

    /**
     * @JMS\Exclude
     * @var string
     *
     * @ORM\Column(name="senha", type="string", length=255, nullable=true)
     */
    private $senha;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=60, nullable=true)
     */
    private $nome;

    /**
     * @JMS\Exclude
     * @var \DateTime
     *
     * @ORM\Column(name="criado_em", type="datetime", nullable=false)
     */
    private $criadoEm;

    public function __construct(array $options = array())
    {
        $this->criadoEm = new \DateTime("now");

        $hydrator = new ClassMethods;
        $hydrator->hydrate($options, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setSenha($senha): Usuario
    {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getCriadoEm()
    {
        return $this->criadoEm;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCriadoEm()
    {
        $this->criadoEm = new \DateTime("now");
        return $this;
    }

    public function toArray()
    {

        $toArray = (new ClassMethods(false))->extract($this);
        unset($toArray['id']);
        unset($toArray['senha']);

        return $toArray;
    }
}