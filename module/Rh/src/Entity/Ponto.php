<?php

namespace Rh\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use JMS\Serializer\Annotation as JMS;

/**
 * rh_ponto
 *
 * @ORM\Table(name="rh_ponto")
 * @ORM\Entity
 */
class Ponto
{
    /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var integer
     *
     * @ORM\Column(name="id_rh_ponto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_entrada", type="string", length=30, nullable=true)
     */
    private $hrEntrada;

        /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_saida", type="string", length=30, nullable=true)
     */
    private $hrSaida;

    /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_entrada_almoco", type="string", length=30, nullable=true)
     */
    private $hrEntradaAlmoco;

        /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_saida_almoco", type="string", length=30, nullable=true)
     */
    private $hrSaidaAlmoco;

        /**
     * @JMS\Groups({"RhPonto"})
     *
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=30, nullable=true)
     */
    private $data;

    /**
     * @JMS\Groups({"RhPonto"})
     *
     * @ORM\ManyToOne(targetEntity="Rh\Entity\Funcionario", inversedBy="rhPonto")
     * @ORM\JoinColumn(name="id_rh_funcionario", referencedColumnName="id_rh_funcionario")
     */
    private $rhFuncionario;

    public function __construct(array $options = array())
    {
        $hydrator = new ClassMethods;
        $hydrator->hydrate($options, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHrEntrada()
    {
        return $this->hrEntrada;
    }

    public function setHrEntrada($hrEntrada)
    {
        $this->hrEntrada = $hrEntrada;
        return $this;
    }

    public function getHrSaida()
    {
        return $this->hrSaida;
    }

    public function setHrSaida($hrSaida)
    {
        $this->hrSaida = $hrSaida;
        return $this;
    }

    public function getHrEntradaAlmoco()
    {
        return $this->hrEntradaAlmoco;
    }

    public function setHrEntradaAlmoco($hrEntradaAlmoco)
    {
        $this->hrEntradaAlmoco = $hrEntradaAlmoco;
        return $this;
    }

    public function getHrSaidaAlmoco()
    {
        return $this->hrSaidaAlmoco;
    }

    public function setHrSaidaAlmoco($hrSaidaAlmoco)
    {
        $this->hrSaidaAlmoco = $hrSaidaAlmoco;
        return $this;
    }

    public function setData($data)
    {
        $this->data = date('Y-m-d H:i', strtotime(str_replace("/", "-", $data)));
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRhFuncionario()
    {
        return $this->rhFuncionario;
    }

    public function setRhFuncionario($rhFuncionario)
    {
        $this->rhFuncionario = $rhFuncionario;
        return $this;
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}