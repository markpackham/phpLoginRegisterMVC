<?php

// load the model and the view
class Controller
{
    public function model($model)
    {
        // Require model file
        require_once "../app/models/" . $model . ".php";
        // Instantiate a model
        return new $model();
    }

    // Look for file in views folder
    public function view($view, $data = [])
    {
        if (file_exists("../app/views/" . $view . ".php")) {
            require_once "../app/views/" . $view . ".php";
        } else {
            die("View does not exist");
        }
    }
}
