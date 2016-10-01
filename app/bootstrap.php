<?php

require '../vendor/autoload.php';

$settings = require 'settings.php';

$app = new Slim\App($settings);
$capsule = new Illuminate\Database\Capsule\Manager;

$container = $app->getContainer();

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule)
{
    return $capsule;
};

$container['TodoListsController'] = function($container)
{
    return new App\Controllers\TodoListsController;
};

$container['TodoItemsController'] = function($container)
{
    return new App\Controllers\TodoItemsController;
};

require 'routes.php';
