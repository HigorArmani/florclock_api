<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Auth\Auth\Adapter;
use Auth\Auth\Token;

class LoginController extends AbstractRestfulController
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Create a new resource
     *
     * @param  mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $this->adapter->setEmail($data['email'])->setSenha($data['senha']);

        if ($this->adapter->isValid()) {
            return Token::generateAuthorization($this->adapter->getPayload());
        }

        exit($this->response->setStatusCode(401));
    }

}