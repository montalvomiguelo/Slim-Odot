<?php

$app->get('/todo_lists', 'TodoListsController:index')
    ->setName('todo_lists.index');

$app->get('/todo_lists/create', 'TodoListsController:create')
    ->setName('todo_lists.create');

$app->post('/todo_lists', 'TodoListsController:store')
    ->setName('todo_lists.store');

$app->get('/todo_lists/{id:\d+}', 'TodoListsController:show')
    ->setName('todo_lists.show');

$app->get('/todo_lists/{id:\d+}/edit', 'TodoListsController:edit')
    ->setName('todo_lists.edit');

$app->put('/todo_lists/{id:\d+}', 'TodoListsController:update')
    ->setName('todo_lists.update');

$app->delete('/todo_lists/{id:\d+}', 'TodoListsController:destroy')
    ->setName('todo_lists.destroy');

$app->get('/todo_lists/{todo_list_id:\d+}/todo_items', 'TodoItemsController:index');

$app->post('/todo_lists/{todo_list_id:\d+}/todo_items', 'TodoItemsController:store');

$app->get('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:show');

$app->put('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:update');

$app->delete('/todo_lists/{todo_list_id:\d+}/todo_items/{id:\d+}', 'TodoItemsController:destroy');
