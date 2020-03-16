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
     * @JMS\Groups({"RhHorario", "RhEscala"})
     *
     * @var integer
     *
     * @ORM\Column(name="id_rh_horario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @JMS\Groups({"RhHorario", "RhEscala"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_entrada", type="string", length=30, nullable=true)
     */
    private $hrEntrada;

        /**
     * @JMS\Groups({"RhHorario", "RhEscala"})
     *
     * @var string
     *
     * @ORM\Column(name="hr_saida", type="string", length=30, nullable=true)
     */
    private $hrSaida;

        /**
     * @JMS\Groups({"RhHorario", "RhEscala"})
     *
     * @ORM\ManyToOne(targetEntity="Base\Entity\Dia", inversedBy="rhHorario")
     * @ORM\JoinColumn(name="id_base_dia", referencedColumnName="id_base_dia")
     */
    private $baseDia;

    /**
     * @JMS\Groups({"RhHorario", "RhEscala"})
     *
     * @ORM\ManyToOne(targetEntity="Rh\Entity\Escala", inversedBy="rhHorario")
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
    
    public function getRhEscala()
    {
        return $this->rhEscala;
    }

    public function setRhEscala($rhEscala)
    {
        $this->rhEscala = $rhEscala;
        return $this;
    }

    public function getBaseDia()
    {
        return $this->baseDia;
    }

    public function setBaseDia($baseDia)
    {
        $this->baseDia = $baseDia;
        return $this;
    }

    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}