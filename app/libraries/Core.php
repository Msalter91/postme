<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Core {

    // Sets the defaults of the app to be the Index Index page (i.e. home)

    protected mixed $currentController = 'Index';
    protected string $currentMethod = 'index';
    protected string $currentControllerDirectory = 'Pages';
    protected $params = [];

    public function __construct(){

        /*
         * At the point of creation - the constructor will call the get URL value
         * It then searches for a file with in the controllers folder that matches.
         * If no file exists by that name, the default page is shown.
         *
         * It then requires the controller and creates an instance of it
         *
         * If there is a second URL part - it then searches for a method that matches that
         * within the current model (created above).
         *
         * Any further parts of the URL are stored in an array
         */

        $url = $this->getUrl();

        if(isset($url[0])) {
            if(file_exists('../app/code/' . ucwords($url[0]) . '/Controllers/' . $url[1] .  '.php')){
                // If exists, set as controller

                //Set the directory from URL[0]
                $this->currentControllerDirectory = ucwords($url[0]);
                // Unset 0 Index
                unset($url[0]);
            }
        }

        if(isset($url[1])){
            $this->currentController = ucwords($url[1]);
            unset($url[1]);
        }

        // Require the controller
        require_once '../app/code/' . $this->currentControllerDirectory . '/Controllers/' . $this->currentController .  '.php';



        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if(isset($url[2])){
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[2])){
                $this->currentMethod = $url[2];
                // Unset 1 index
                unset($url[2]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){

        /*
         * Pulls the url down and trims any trailing slashed
         * Then returns an array split at '/' which will become our model and view
         */

        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
    }
}