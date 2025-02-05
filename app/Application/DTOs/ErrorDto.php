<?php

namespace App\Application\DTOs;

class ErrorDto
{
    private int $code;
    private array $errorList;

    public function __construct(array $errorList, int $code = 400)
    {
        $this->code = $code;
        $this->errorList = $errorList;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getErrorList(): array
    {
        return $this->errorList;
    }

    public function setErrorList(array $errorList): void
    {
        $this->errorList = $errorList;
    }
}
