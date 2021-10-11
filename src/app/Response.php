<?php

namespace App\app;

class Response {


    public function setStatusCode(int $code) {
        http_response_code($code);
    }
}