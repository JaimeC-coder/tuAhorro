<?php

namespace App\Http\Response;

use Exception;


class ApiValidationException extends Exception
{
    protected $errors;
    protected $statusCode;
    protected $message;
    protected $status;
    protected $total;

    public function __construct(array $errors, $message = 'Error en la API', $status = false, $total = 0, $statusCode = 422)
    {
        parent::__construct($message, $statusCode);
        $this->errors = $errors;
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->status = $status;
        $this->total = $total;
    }

    public function render()
    {
        return $this->errors;
    }
}
