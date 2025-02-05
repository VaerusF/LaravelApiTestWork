<?php

namespace App\Application\UseCases\Company\Command\DeleteCompany;

class DeleteCompanyCommand
{
    public function __construct(public int $id) {}
}
