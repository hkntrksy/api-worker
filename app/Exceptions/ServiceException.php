<?php

namespace App\Exceptions;

use Exception;

class ServiceException extends Exception
{


    /**
     * RepositoryException constructor.
     * @param string $statusCode
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(private $statusCode, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

}
