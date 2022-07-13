<?php

declare(strict_types=1);

namespace library;

abstract class Controller
{
    // Load model

    public function model($model)
    {
        //require the model that we want
//        require_once '../app/models/' . $model . '.php';
        require_once '../app/code/' . ucwords($model) . '/Model/' . $model . '.php';

        // Create a new instance of that model

        return new $model();
    }

    //Load View

    public function view($view, $data, $errors = [])
    {
        // Check if view exists
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            //If view does not exist
            //TODO Add some error handling
            die($view);
        }
    }
}