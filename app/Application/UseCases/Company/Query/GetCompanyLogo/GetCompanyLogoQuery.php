<?php

namespace App\Application\UseCases\Company\Query\GetCompanyLogo;

class GetCompanyLogoQuery
{
    public function __construct(public int $companyId)
    {
    }
}
