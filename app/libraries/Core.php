<?php

declare(strict_types=1);

namespace library;

class Core
{
    protected mixed $currentController = 'Index';
    protected string $currentMethod = 'index';
    protected string $currentControllerDirectory = 'Pages';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if (isset($url[0])) {
            if (file_exists('../app/code/' . ucwords($url[0]) . '/Controllers/' . $url[1] . '.php')) {
                $this->currentControllerDirectory = ucwords($url[0]);

                unset($url[0]);
            }
        }

        if (isset($url[1])) {
            $this->currentController = ucwords($url[1]);
            unset($url[1]);
        }


        require_once '../app/code/' . $this->currentControllerDirectory .
            '/Controllers/' . $this->currentController . '.php';

        $this->currentController = new $this->currentController();


        if (isset($url[2])) {
            if (method_exists($this->currentController, $url[2])) {
                $this->currentMethod = $url[2];

                unset($url[2]);
            }
        }


        $this->params = $url ? array_values($url) : [];


        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(): ?array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        } else {
            return [];
        }
    }
}
