<?php

namespace App\app;

class Router {

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback): void {
        // echo '<pre>';
        // var_dump($_SERVER);
        // echo '</pre>';
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function handle() {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();
            $callback = $this->routes[$method][$path] ?? false;

            if (false === $callback) {
                $this->response->setStatusCode(404);
                return 'not_found_oooi';
            }

            if (is_string($callback)) {
                return $this->render($callback);
            }

            // echo '<pre>';
            // var_dump($callback);
            // echo '<pre>';

            if (is_array($callback)) {
                $callback[0] = new $callback[0]();
            }

            return call_user_func($callback, $this->request);
    }


    public function render(string $path) {
        return $this->getViewContent($path);
    }

    protected function getViewContent(string $file) {
        $ext = '.php';

        ob_start();
        
        if (is_file(VIEWPATH.$file.$ext)) {
            include_once VIEWPATH.$file.$ext;
        } else {
            echo realpath($file).' is not found';
        }

        return ob_get_clean();
    }
}