<?php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Verifica se o controller existe
        if (isset($url[0]) && file_exists("../app/controllers/" . ucfirst($url[0]) . "Controller.php")) {
            $this->controller = ucfirst($url[0]) . "Controller";
            unset($url[0]);
        }

        // Inclui o controller
        require_once "../app/controllers/" . $this->controller . ".php";
        $this->controller = new $this->controller;

        // Verifica se o método existe
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Parâmetros
        $this->params = $url ? array_values($url) : [];

        // Executa o método com os parâmetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
