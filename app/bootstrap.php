<?php

ini_set('display_errors', true);

session_start();

require '../vendor/autoload.php';

$app = new Slim\App(
    require 'settings.php'
);

$container = $app->getContainer();

$container['db'] = function($container)
{
    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    return $capsule;
};

$container['view'] = function($container)
{
    $view = new Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
        'debug' => true
    ]);

    $view->addExtension(new Twig_Extension_Debug());

    $view->addExtension(new Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $view->addExtension(
        new App\TwigExtension(
            $container['csrf'],
            $container['flash']
        )
    );

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

$container['csrf'] = function($container)
{
    return new Slim\Csrf\Guard;
};

$container['db']->bootEloquent();

$app->add($container->csrf);

require 'routes.php';
