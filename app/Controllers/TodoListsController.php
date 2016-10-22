<?php

namespace App\Controllers;

use App\Models\TodoList;
use Slim\Views\Twig as View;
use Slim\Router;
use Slim\Flash\Messages as Flash;

class TodoListsController {

    protected $view;
    protected $router;
    protected $flash;

    public function __construct(View $view, Router $router, Flash $flash)
    {
        $this->view = $view;
        $this->router = $router;
        $this->flash = $flash;
    }

    public function view()
    {
        return $this->view;
    }

    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'todo_lists/index.twig', [
            'todo_lists' => TodoList::all(),
            'csrf' => [
                'name' => $request->getAttribute('csrf_name'),
                'value' => $request->getAttribute('csrf_value'),
            ],
        ]);
    }

    public function create($request, $response, $args)
    {
        return $this->view->render($response, 'todo_lists/create.twig', [
            'messages' => $this->flash->getMessages(),
            'csrf' => [
                'name' => $request->getAttribute('csrf_name'),
                'value' => $request->getAttribute('csrf_value'),
            ],
        ]);
    }

    public function show($request, $response, $args)
    {
        return $this->view->render($response, 'todo_lists/show.twig', [
            'todo_list' => TodoList::findOrFail($args['id'])
        ]);
    }

    public function store($request, $response, $args)
    {

        $todoList = new TodoList;

        $data = $request->getParsedBody();

        $validator = $todoList->validator($data);

        if (! $validator->validate()) {

            $errors = $validator->errors();

            foreach ($errors as $label => $value) {
                $this->flash->addMessage($label, $this->firstErrorFrom($value));
            }

            return $response->withRedirect($this->router->pathFor('todo_lists.create'));
        }

        $todoList->title = $data['title'];

        $todoList->save();

        return $response->withRedirect($this->router->pathFor('todo_lists.index'));

    }

    public function edit($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['id']);

        return $this->view->render($response, 'todo_lists/edit.twig', [
            'messages' => $this->flash->getMessages(),
            'todo_list' => $todoList,
            'csrf' => [
                'name' => $request->getAttribute('csrf_name'),
                'value' => $request->getAttribute('csrf_value'),
            ],
        ]);

    }

    public function update($request, $response, $args)
    {
        $todoList = TodoList::findOrFail($args['id']);

        $data = $request->getParsedBody();

        $validator = $todoList->validator($data);

        if (! $validator->validate()) {

            $errors = $validator->errors();

            foreach ($errors as $label => $value) {
                $this->flash->addMessage($label, $this->firstErrorFrom($value));
            }

            return $response->withRedirect($this->router->pathFor(
                'todo_lists.edit', [id => $args['id']]
            ));
        }

        $todoList->title = $data['title'];

        $todoList->save();

        return $response->withRedirect($this->router->pathFor('todo_lists.index'));
    }

    public function destroy($request, $response, $args)
    {
        TodoList::destroy($args['id']);

        return $response->withRedirect($this->router->pathFor('todo_lists.index'));
    }

    protected function firstErrorFrom($value)
    {
        return array_shift($value);
    }

}
