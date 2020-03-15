<?php

namespace Rh\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use JMS\Serializer\Annotation as JMS;

/**
 * rh_funcionario
 *
 * @ORM\Table(name="rh_funcionario")
 * @ORM\Entity
 */
class Funcionario
{
    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @var integer
     *
     * @ORM\Column(name="id_rh_funcionario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=30, nullable=true)
     */
    private $nome;

    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=30, nullable=true)
     */
    private $foto;

    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @ORM\ManyToOne(targetEntity="Rh\Entity\Escala", inversedBy="rhFuncionario")
     * @ORM\JoinColumn(name="id_rh_escala", referencedColumnName="id_rh_escala")
     */
    private $rhEscala;

    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods;
        $hydrator->hydrate($options, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
        return $this;
    }

    public function getEscala()
    {
        return $this->escala;
    }

    public function setEscala($escala)
    {
        $this->escala = $escala;
        return $this;
    }
    
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}