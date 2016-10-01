<?php

$app->get('/todo_lists', 'TodoListsController:index');

$app->post('/todo_lists', 'TodoListsController:store')
    ->add('App\Validators\TodoListValidator');

$app->get('/todo_lists/{id:\d+}', 'TodoListsController:show');

$app->put('/todo_lists/{id:\d+}', 'TodoListsController:update')
    ->add('App\Validators\TodoListValidator');

$app->delete('/todo_lists/{id:\d+}', 'TodoListsController:destroy');

$app->get('/todo_lists/{todo_list_id:\d+}/todo_items', 'TodoItemsController:index');

$app->post('/todo_lists/{todo_list_id:\d+}/todo_items', 'TodoItemsController:store')
    ->add('App\Validators\TodoListValidator');

$app->get('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:show');

$app->put('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:update')
    ->add('App\Validators\TodoListValidator');

$app->delete('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:destroy');
