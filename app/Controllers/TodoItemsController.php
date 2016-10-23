<?php

namespace App\Controllers;

use App\Models\TodoList;
use App\Models\TodoItem;

class TodoItemsController {

    public function index($request, $response, $args)
    {
        return $response->withJson(
            TodoList::findOrFail($args['todo_list_id'])->todoItems
        );
    }

    public function store($request, $response, $args)
    {
        $todoItem = new TodoItem($request->getParsedBody());

        return $response->withJson(
            TodoList::findOrFail($args['todo_list_id'])->todoItems()->save($todoItem)
        );
    }

    public function update($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['todo_list_id']);

        $todoItem = $todoList->todoItems()->findOrFail($args['id']);

        $todoItem->update($request->getParsedBody());

        return $response->withJson($todoItem);
    }

    public function destroy($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['todo_list_id']);

        $todoList->todoItems()->findOrFail($args['id'])->delete();
    }

    public function show($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['todo_list_id']);

        return $response->withJson(
            $todoList->todoItems()->findOrFail($args['id'])
        );
    }

}
