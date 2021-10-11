<?php

namespace App\controllers;

use App\services\checkout\CheckoutService;

class ApiController {

    public function invoice() {
        // get post data from input streams instead of superglobal $_POST
        // data
        $data = json_decode(file_get_contents('php://input'), true);

        $service = new CheckoutService();
        return $service->createInvoice($data);
    }
}