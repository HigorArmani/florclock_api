<?php

namespace Base\Service;

use Zend\Hydrator\ClassMethods;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractService
{
    /**
     *
     * @var type EntityManagerInterface
     */
    protected $em;

    /**
     *
     * @var type String
     */
    protected $entity;

    /**
     *
     * @param Doctrine\ORM\EntityManager $em
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     *
     * @param array $data
     * @return \Base\Service\entity
     */
    public function insert(array $data)
    {
        $entity = new $this->entity($data);

        $this->em->persist($entity);
        $this->em->flush();

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
        $entity = $this->em->getReference($this->entity, $id);

        $hydrator = new ClassMethods;
        $hydrator->hydrate($data, $entity);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     *
     * @param int $id
     * @param array $data
     * @return type
     */
    public function patchList(array $data)
    {
        foreach ($data as $d) {
            $entity = $this->em->getReference($this->entity, (int) $d['id']);

            $hydrator = new ClassMethods;
            $hydrator->hydrate($d, $entity);

            $this->em->persist($entity);
        }

        $this->em->flush();

        return $data;
    }

   /**
    *
    * @param type $id
    * @return type
    */
    public function delete($id)
    {
        $entity = $this->em->getReference($this->entity, (int) $id);

        $this->em->remove($entity);
        $this->em->flush();

        return compact('id');
    }

    /**
     *
     * @param array $ids (id=1,2,3,4)
     * @return type
     */
    public function deleteList(String $ids)
    {

        $collection = explode(',', $ids);

        foreach ($collection as $id) {
            $entity = $this->em->getReference($this->entity, (int) $id);
            $this->em->remove($entity);
        }

        $this->em->flush();

        return ["ids" => $collection];
    }
}