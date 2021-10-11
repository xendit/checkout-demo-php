<?php

namespace App\app;

class Request {

    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if (false === $position) {
            return $path;
        }

        return substr($path, 0, $position);
    }


    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    public function getBody() {
        $body = [];

        if ('get' === $this->getMethod()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ('post' === $this->getMethod()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}