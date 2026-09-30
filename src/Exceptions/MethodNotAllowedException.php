<?php

namespace STS\HubSpot\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class MethodNotAllowedException extends Exception
{
    public function __construct(public Response $response, $message = 'Method not allowed', $code = 405)
    {
        parent::__construct($message, $code);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
