<?php

namespace Base;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [

            'base-dia-router' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/base/dias[/:id]',
                    'defaults' => [
                        'controller' => \Base\DiasController::class
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
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__.'/../view/layout/layout.phtml',
            'base/index/index' => __DIR__.'/../view/index/index.phtml',
            'error/404' => __DIR__.'/../view/error/404.phtml',
            'error/index' => __DIR__.'/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'Base_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../Base/src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Base\Entity' => 'Base_driver'
                ]
            ]
        ],
    ],
];