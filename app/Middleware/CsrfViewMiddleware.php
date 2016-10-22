<?php

namespace App\Middleware;

use Slim\Views\Twig as View;
use Slim\Csrf\Guard as Csrf;

class CsrfViewMiddleware {

    protected $view;
    protected $csrf;

    public function __construct(View $view, Csrf $csrf)
    {
        $this->view = $view;
        $this->csrf = $csrf;
    }

    public function __invoke($request, $response, $next)
    {
        $this->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
                <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
            ',
        ]);

        $response = $next($request, $response);

        return $response;

    }

}
