<?php

namespace App\Controllers;

use App\Models\TodoList;

class TodoListsController {

    public function index($request, $response, $args)
    {
        return $response->withJson(
            TodoList::all()
        );
    }

    public function show($request, $response, $args)
    {
        return $response->withJson(
            TodoList::findOrFail($args['id'])
        );
    }

    public function store($request, $response, $args)
    {
        return $response->withJson(
            TodoList::create($request->getParsedBody())
        );
    }

    public function update($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['id']);

        $todoList->update($request->getParsedBody());

        return $response->withJson($todoList);
    }

    public function destroy($request, $response, $args)
    {
        TodoList::destroy($args['id']);
    }

}
