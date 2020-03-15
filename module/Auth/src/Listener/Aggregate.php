<?php

namespace Auth\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Auth\Auth\Token;

class Aggregate implements ListenerAggregateInterface
{
    const METHOD_POST      = 'POST';
    const MODULE_AUTH      = "Auth";
    const LOGIN_CONTROLLER = "Auth\LoginController";

    use ListenerAggregateTrait;

    public function __construct()
    {
        
    }

    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH,
            [$this, 'checkAccess'], $priority);
    }

    public function checkAccess(EventInterface $event)
    {

        /**
         * Verificar se esta authenticado
         */
     //   $this->isAuthenticated($event);

        /**
         * Checar as permissoes
         */
     //   $this->isAuthorized($event);
    }

    // Verifica a autorização
    private function isAuthorized(EventInterface $event)
    {

        /**
         * Recuperando os parametros da rota
         */
        $params = $event->getRouteMatch()->getParams();

        /**
         * Recuperando o verbo (GET, POST, PUT, DELETE...)
         */
        $method = strtoupper($event->getRequest()->getMethod());

        /**
         * Recuperando o nome do modulo que esta sendo utilizado
         */
        $module = explode('\\', $params['controller'])[0];

        /**
         * Essa regra garante que qualquer pessoa possa se cadastrar
         * caso contrario esse bloco deve ser adptado
         */
        if ($module === self::MODULE_AUTH && $method === self::METHOD_POST) {
            return true;
        }
    }

    // Verifica a Authenticação
    private function isAuthenticated(EventInterface $event)
    {

        $className = $event->getRouteMatch()->getParams()['controller'];

        if ($className !== self::LOGIN_CONTROLLER) {

            $headers       = $event->getRequest()->getHeaders()->get('Authorization');
            $authorization = false;

            $response = $event->getResponse();

            if ($headers) {
                $authorization = $headers->getFieldValue();
            } else {
                $response->setStatusCode(401);
                $response->sendHeaders();
                exit;
            }

            if (!Token::validateSignature($authorization)) {
                $response->setStatusCode(203);
                $response->sendHeaders();
                exit;
            }
        }

        return false;
    }
}