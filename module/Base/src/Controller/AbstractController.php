<?php

namespace Base\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Base\Service\ApiService;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;

abstract class AbstractController extends AbstractRestfulController
{
    protected $em;
    protected $apiService;
    protected $service;
    protected $entity;
    protected $groups;

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        $this->em         = $em;
        $this->apiService = $apiService;
        $this->service    = $service;
    }

    protected function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * Return single resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function get($id)
    {

        $request = $this->getRequest();
        $request->getQuery()->set('id', $id);

        $data = $this->apiService->getList($this->getRequest(), $this->entity)->getResult();

        if (isset($data[1])) {
            return $this->response($this->jmsSerializer($data));
        }

        if (isset($data[0])) {
            return $this->response($this->jmsSerializer([$data[0]]));
        } else {
            return new JsonModel([]);
        }
    }

    /**
     * Return list of resources
     *
     * @return mixed
     */
    public function getList()
    {
        $data = $this->apiService->getList($this->getRequest(), $this->entity)->getResult();
        return $this->response($this->jmsSerializer($data));
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $result = $this->service->insert($data);

        /**
         * O Resultado em array significa inserção de multiplos valores
         */
        if (is_array($result)) {

            $value = [];
            foreach ($result as $key => $r) {
                $value["in"] = implode(',', array_filter($result["id"]));
            }

            $this->getRequest()->getQuery()->set($key, $value);
            $response = $this->getList();
        } else {
            $response = $this->get($result->getId());
        }

        return $response;
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $this->service->update($id, $data);

        $response = $this->get($id);

        return $response;
    }

    /**
     * Replace an entire resource collection
     *
     * Not marked as abstract, as that would introduce a BC break
     * (introduced in 2.1.0); instead, raises an exception if not implemented.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function replaceList($data)
    {
        $result = $this->service->replaceList($data);

        $value  = [];
        foreach ($result as $key => $r) {
            $value["in"] = implode(',', array_filter($result["id"]));
        }

        $this->getRequest()->getQuery()->set($key, $value);
        return $this->getList();
    }

    /**
     * Update an existing resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function patchList($data)
    {
        //  $result = $this->service->patchList($data);
        //  return new JsonModel($result);
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        // se true is delete list (id=1,2,3,4)
        if (strpos($id, ',')) {
            $result = $this->service->deleteList($id);
        } else {
            $result = $this->service->delete($id);
        }

        return new JsonModel($result);
    }

    protected function jmsSerializer($data)
    {
        $serializer = SerializerBuilder::create();
        $serializer->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy);

        $context = new SerializationContext;
        $context->setSerializeNull(true);

        if ($this->groups) {
            $context->setGroups($this->groups);
        }

        $jsonContent = $serializer->build()->serialize($data, 'json', $context->enableMaxDepthChecks());

        return $jsonContent;
    }

    protected function response($data)
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaders([
            'Content-type' => 'application/json',
        ]);

        return $response->setContent($data);
    }
}