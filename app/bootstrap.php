<?php

session_start();

require '../vendor/autoload.php';

$settings = require 'settings.php';

$app = new Slim\App($settings);
$capsule = new Illuminate\Database\Capsule\Manager;

$container = $app->getContainer();

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['view'] = function($container)
{
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
        'debug' => true
    ]);

    $view->addExtension(new Twig_Extension_Debug());

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;

};

$container['flash'] = function ($container) {
    return new Slim\Flash\Messages;
};

$container['TodoListsController'] = function($container)
{
    return new App\Controllers\TodoListsController(
        $container->view,
        $container->router,
        $container->flash
    );
};

$container['TodoItemsController'] = function($container)
{
    return new App\Controllers\TodoItemsController;
};

require 'routes.php';
