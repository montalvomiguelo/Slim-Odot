<?php

namespace App\Controllers;

use App\Models\TodoList;
use App\Models\TodoItem;
use Slim\Views\Twig as View;
use Slim\Router;
use Slim\Flash\Messages as Flash;

class TodoItemsController {

    protected $view;
    protected $router;
    protected $flash;

    public function __construct(View $view, Router $router, Flash $flash)
    {
        $this->view = $view;
        $this->router = $router;
        $this->flash = $flash;
    }

    public function create($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['todo_list_id']);

        return $this->view->render($response, 'todo_items/create.twig', [
            'todo_list' => $todoList,
        ]);

    }

    public function store($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['todo_list_id']);

        $todoItem = new TodoItem;

        $data = $request->getParsedBody();

        $validator = $todoItem->validator($data);

        if (!$validator->validate() ) {

            $errors = $validator->errors();

            foreach ($errors as $label => $value) {
                $this->flash->addMessage('error', array_shift($value));
            }

            return $response->withRedirect($this->router->pathFor(
                'todo_items.create', [todo_list_id => $args['todo_list_id']]
            ));
        }

        $todoItem->title = $data['title'];

        $todoList->todoItems()->save($todoItem);

        $this->flash->addMessage('success', 'Todo Item was successfully added.');

        return $response->withRedirect($this->router->pathFor(
            'todo_lists.show', [id => $args['todo_list_id']]
        ));

    }

    public function edit($request, $response, $args)
    {
        $todoItem = TodoItem::findOrFail($args['id']);

        return $this->view->render($response, 'todo_items/edit.twig', [
            'todo_item' => $todoItem,
        ]);
    }

    public function update($request, $response, $args)
    {

        $todoItem = TodoItem::findOrFail($args['id']);

        $data = $request->getParsedBody();

        $validator = $todoItem->validator($data);

        if (! $validator->validate()) {

            $errors = $validator->errors();

            foreach ($errors as $label => $value) {
                $this->flash->addMessage('error', array_shift($value));
            }

            return $response->withRedirect($this->router->pathFor(
                'todo_items.edit', [id => $args['id']]
            ));
        }

        $todoItem->title = $data['title'];

        $todoItem->save();

        $this->flash->addMessage('success', 'Todo Item was successfully updated.');

        return $response->withRedirect($this->router->pathFor(
            'todo_lists.show', [id => $todoItem->todoList->id]
        ));
    }

    public function destroy($request, $response, $args)
    {
        $todoItem = TodoItem::findOrFail($args['id']);

        $todoItem->delete();

        $this->flash->addMessage('success', 'Todo Item was successfully destroyed.');

        return $response->withRedirect($this->router->pathFor(
            'todo_lists.show', [id => $todoItem->todoList->id]
        ));
    }

}
