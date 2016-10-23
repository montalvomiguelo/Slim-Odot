<?php

namespace App;

use Slim\Csrf\Guard as Csrf;
use Slim\Flash\Messages as Flash;

class TwigExtension extends \Twig_Extension {

    protected $csrf;
    protected $flash;

    public function __construct(Csrf $csrf, Flash $flash)
    {
        $this->csrf = $csrf;
        $this->flash = $flash;
    }

    public function getName()
    {
        return 'app';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('csrf_field', [$this, 'csrfProtection'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('flash_messages', [$this, 'flashMessages']),
        ];
    }

    public function csrfProtection()
    {
        return '
            <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
            <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
        ';
    }

    public function flashMessages($messageKey = '')
    {
        $messages = $this->flash->getMessages();

        if (! array_key_exists($messageKey, $messages)) {
            return NULL;
        }

        return $messages[$messageKey];
    }

}
