<?php

namespace Rh;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [

            'rh-funcionario-router' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/rh/funcionarios[/:id]',
                    'defaults' => [
                        'controller' => \Rh\FuncionariosController::class
                    ],
                    'constraints' => [
                        'id' => '[0-9]+'
                    ],
                ],
            ],

            'rh-ponto-router' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/rh/pontos[/:id]',
                    'defaults' => [
                        'controller' => \Rh\PontosController::class
                    ],
                    'constraints' => [
                        'id' => '[0-9]+'
                    ],
                ],
            ],

            'rh-horario-router' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/rh/horarios[/:id]',
                    'defaults' => [
                        'controller' => \Rh\HorariosController::class
                    ],
                    'constraints' => [
                        'id' => '[0-9]+'
                    ],
                ],
            ],

        ],
    ],
    'controllers' => [
        'factories' => [
            
        ],
    ],
    'doctrine' => [
        'driver' => [
            'Rh_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../Rh/src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Rh\Entity' => 'Rh_driver'
                ]
            ]
        ],
    ],
];