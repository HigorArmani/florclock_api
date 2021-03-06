<?php

namespace Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Hydrator\ClassMethods;
use JMS\Serializer\Annotation as JMS;

/**
 * base_dia
 *
 * @ORM\Table(name="base_dia")
 * @ORM\Entity
 */
class Dia
{
    /**
     * @JMS\Groups({"BaseDia", "RhEscala"})
     *
     * @var integer
     *
     * @ORM\Column(name="id_base_dia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @JMS\Groups({"BaseDia", "RhFuncionario", "RhHorario", "RhEscala"})
     *
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=30, nullable=true)
     */
    private $nome;

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
    
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }
}