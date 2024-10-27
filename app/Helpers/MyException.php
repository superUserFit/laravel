<?php

namespace App\Helpers;


class MyException extends \Exception {
    protected $statusCode;

    public function __construct(\Exception $error, int $statusCode) {
        parent::__construct($error->getMessage());
        $this->statusCode = $statusCode;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
}
