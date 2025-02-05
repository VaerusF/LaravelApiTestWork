<?php

namespace App\Application\DTOs\Company;

class CompanyRating
{
    public function __construct(public CompanyDto $companyDto, public float $rating)
    {
    }
}
