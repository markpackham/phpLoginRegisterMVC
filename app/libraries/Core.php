<?php

class Core
{
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    // holds key parts of url
    // eg http://example.com/shop/glasses/men
    protected $params = [];

    public function __construct()
    {
        // print_r($this->getUrl());
        $url = $this->getUrl();

        // look in controllers for first value (remember we access stuff first via the public folder so need "../app")
        // ucwords, uppercase the first character of each word in a string
        if (isset($url)) {
            if (file_exists("../app/controllers/" . ucwords($url[0]) . ".php")) {
                // will set a new controller
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }
        }

        // Require the controller
        require_once "../app/controllers/" . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check for 2nd url part
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Get params if there are any, if not keep params empty
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], "/");

            // forbid characters that the url shouldn't have eg @ or $
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // break into an array
            $url = explode("/", $url);
            return $url;
        }
    }
}
