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
     * @JMS\Groups({"RhFuncionario", "RhPonto"})
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
     * @var integer
     *
     * @ORM\Column(name="hr_saldo", type="integer", length=30, nullable=true)
     */
    private $hrSaldo;
    
    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_ultima", type="string", length=30, nullable=true)
     */
    private $hrUltima;

    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @ORM\ManyToOne(targetEntity="Rh\Entity\Escala", inversedBy="rhFuncionario")
     * @ORM\JoinColumn(name="id_rh_escala", referencedColumnName="id_rh_escala")
     */
    private $rhEscala;
    
    /**
     * @JMS\Groups({"RhFuncionario"})
     *
     * @ORM\ManyToOne(targetEntity="Rh\Entity\FuncionarioStatus", inversedBy="rhFuncionario")
     * @ORM\JoinColumn(name="id_rh_funcionario_status", referencedColumnName="id_rh_funcionario_status")
     */
    private $rhFuncionarioStatus;

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

    public function getFoto()
    {
        return $this->foto;
    }

    public function getHrSaldo()
    {
        return $this->hrSaldo;
    }

    public function getRhEscala()
    {
        return $this->rhEscala;
    }

    public function getRhFuncionarioStatus()
    {
        return $this->rhFuncionarioStatus;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
        return $this;
    }

    public function setHrSaldo($hrSaldo)
    {
        $this->hrSaldo = $hrSaldo;
        return $this;
    }

    public function setRhEscala($rhEscala)
    {
        $this->rhEscala = $rhEscala;
        return $this;
    }

    public function setRhFuncionarioStatus($rhFuncionarioStatus)
    {
        $this->rhFuncionarioStatus = $rhFuncionarioStatus;
        return $this;
    }

    public function getHrUltima()
    {
        return $this->hrUltima;
    }

    public function setHrUltima($hrUltima)
    {
        $this->hrUltima = $hrUltima;
        return $this;
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}