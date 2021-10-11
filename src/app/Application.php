<?php

namespace App\app;

class Application {

    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct() {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        echo $this->router->handle();
    }
}