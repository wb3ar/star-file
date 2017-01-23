<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$settings = include 'src/settings.php';
$settings = $settings['settings']['doctrine'];
$config = Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['isDevMode']
);

$entityManager = EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($entityManager);
