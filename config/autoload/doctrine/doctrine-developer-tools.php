<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/* 
    Developer Mode
*/
$paths = [
    __DIR__ . '/Entity'
];

$devMode = true;

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '',
    'dbname' => ''
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $devMode);
$entityManager = EntityManager::create($dbParams, $config);

function getEntityManager(){
    global $entityManager;
    return $entityManager;
}