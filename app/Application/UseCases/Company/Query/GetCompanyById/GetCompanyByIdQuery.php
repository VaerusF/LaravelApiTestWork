<?php

namespace App\Application\UseCases\Company\Query\GetCompanyById;

class GetCompanyByIdQuery
{
    public function __construct(public int $id) {}
}
