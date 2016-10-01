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
            return $response->withJson(['errors' => $validator->errors()])
                            ->withStatus(422);
        }

        return $next($request, $response);
    }

}
