<?php

namespace App\Validators;

use Valitron\Validator;

class TodoListValidator {

    public function __invoke($request, $response, $next)
    {
        $validator = new Validator(
            $request->getParsedBody()
        );

        $validator->rule('required', 'title');

        if (! $validator->validate())
        {
            //$e = ['errors' => $validator->errors()];
            //$response = $this->renderer->render($request, $response, $e);
            //return $response->withStatus(422);
            //return $response->withStatus(422)
                            //->withHeader('Location', 'todo_lists/create');
            die(var_dump($this));
            exit;
            return $response->withHeader('Location', 'todo_lists/create')
                            ->withStatus(422);
        }

        return $next($request, $response);
    }

}
