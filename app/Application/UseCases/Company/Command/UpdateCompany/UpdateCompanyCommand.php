<?php

namespace App\Application\UseCases\Company\Command\UpdateCompany;

use App\Application\DTOs\Company\UpdateCompanyDto;

class UpdateCompanyCommand
{
    public function __construct(public int $companyId, public UpdateCompanyDto $dto)
    {
    }
}
