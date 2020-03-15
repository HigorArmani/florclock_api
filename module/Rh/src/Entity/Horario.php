<?php

namespace Rh\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use JMS\Serializer\Annotation as JMS;

/**
 * rh_horario
 *
 * @ORM\Table(name="rh_horario")
 * @ORM\Entity
 */
class Horario
{
    /**
     * @JMS\Groups({"RhHorario"})
     *
     * @var integer
     *
     * @ORM\Column(name="id_rh_horario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @JMS\Groups({"RhHorario"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_entrada", type="string", length=30, nullable=true)
     */
    private $hrEntrada;

        /**
     * @JMS\Groups({"RhHorario"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_saida", type="string", length=30, nullable=true)
     */
    private $hrSaida;

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
    
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}