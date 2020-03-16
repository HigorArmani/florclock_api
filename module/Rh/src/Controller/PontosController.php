<?php

namespace Rh\Controller;

use Base\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Base\Service\ApiService;

class PontosController extends AbstractController
{

    protected $entity = "Rh\Entity\Ponto";
    protected $groups = ["RhPonto"];

    public function __construct(EntityManagerInterface $em,
                                ApiService $apiService, $service)
    {
        parent::__construct($em, $apiService, $service);
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
}