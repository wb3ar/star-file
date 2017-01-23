<?php
// Routes

$app->get('/files', function ($request, $response) {
    return require_once 'controllerFilesGet.php';
});

$app->get('/search', function ($request, $response) {
    return require_once 'controllerSearchGet.php';
});

$app->get('/', function ($request, $response) {
    return require_once 'controllerIndexGet.php';
});

$app->post('/', function ($request, $response) {
    return require_once 'controllerIndexPost.php';
});

$app->get('/{id}', function ($request, $response, $args) {
    return require_once 'controllerIdGet.php';
});

$app->post('/{id}', function ($request, $response, $args) {
    return require_once 'controllerIdPost.php';
});

$app->get('/download/{id}', function ($request, $response, $args) {
    return require_once 'controllerDownloadIdGet.php';
});
$app->get('/tag/{id}', function ($request, $response, $args) {
    return require_once 'controllerTagIdGet.php';
});
