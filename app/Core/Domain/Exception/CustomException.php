<?php

namespace App\Core\Domain\Exception;

abstract class CustomException extends \Exception
{
    protected int $statusCode;

    public function __construct(int $statusCode)
    {
        $this->statusCode = $statusCode;
        parent::__construct();
    }

    public function __constructWithMessage(int $statusCode, string $message): void
    {
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
