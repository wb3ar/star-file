<?php
// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// Doctrine
$container['entityManager'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['isDevMode']
    );

    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

// Register component on container
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// Sphinx
$container['sphinx'] = function ($c) {
    $settings = $c->get('settings')['sphinx'];
    $sphinx = new SphinxClient();
    $sphinx->setServer($settings['host'], $settings['port']);

    return $sphinx;
};

// FFMpeg
$container['ffmpeg'] = function ($c) {
    $settings = $c->get('settings')['ffmpeg'];
    $ffmpeg = \FFMpeg\FFMpeg::create($settings);

    return $ffmpeg;
};
