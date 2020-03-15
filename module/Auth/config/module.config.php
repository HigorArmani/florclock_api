<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'auth-v1-login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/auth/login',
                    'defaults' => [
                        'controller' => LoginController::class
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
        ],
    ],
    'view_manager' => [
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
    'doctrine' => [
        'driver' => [
            'Auth_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../Auth/src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Auth\Entity' => 'Auth_driver'
                ]
            ]
        ],
    ],
];
