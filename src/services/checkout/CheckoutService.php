<?php

namespace App\services\checkout;

use Closure;
use Dotenv\Dotenv;
use Xendit\Xendit;

class CheckoutService {

    public function createInvoice($args) {
        // $data = json_decode(file_get_contents('php://input'), true);
        // return json_encode($data);
        $env = Dotenv::createUnsafeImmutable(dirname(BASEPATH));
        $env->load();
        $apiKey = $this->env('API_KEY');
        // var_dump($apiKey);

        $date = new \DateTime();
        $redirectUrl = '';
        $defParams = [
            'external_id' => 'native8-checkout-demo-' . $date->getTimestamp(),
            'payer_email' => 'invoice+demo@xendit.co', 
            'description' => 'Vanilla PHP Checkout Demo', 
            'failure_redirect_url' => $redirectUrl, 
            'success_redirect_url' => $redirectUrl
        ];

        $defParams['failure_redirect_url'] = $args['redirect_url'];
        $defParams['success_redirect_url'] = $args['redirect_url'];
        $post = [];

        foreach ($args as $k => $v) {
            $post[$k] = $v;
        }
        
        $params = array_merge($defParams, $post);

        // return json_encode($params);

        header('Content-Type: application/json');
        $response = [];

        try {
            Xendit::setApiKey($apiKey);

            $response = \Xendit\Invoice::create($params);
        } catch (\Exception $e) {
            http_response_code($e->getCode());
            $response['message'] = $e->getMessage();
        }

        return json_encode($response);
    }

    private function value($value) {
        return $value instanceof Closure ? $value() : $value;
    }

    private function env($key, $default = null) {
        $value = getenv($key);

        if (false === $value) {
            return $this->value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (($valuelen = strlen($value)) > 1 && $value[0] === '"' && $value[$valuelen - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }
}