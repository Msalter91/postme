<?php

declare(strict_types=1);

namespace library;

abstract class Controller
{
    public function model($model): object
    {
        require_once '../app/code/' . ucwords($model) . '/Model/' . $model . '.php';
        return new $model();
    }
    public function view($view, $data, $errors = []): void
    {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        }
    }

    public function errorHandler($e, string $redirctLocation): void
    {
        flash('post_message', $e->getMessage(), 'alert alert-danger');
        redirect($redirctLocation);
    }
}
