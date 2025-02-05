<?php

namespace App\Application\UseCases\Company\Command\CreateCompany;

use App\Application\DTOs\Company\CreateCompanyDto;

class CreateCompanyCommand
{
    public function __construct(public CreateCompanyDto $dto)
    {
    }
}
