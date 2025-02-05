<?php

namespace App\Application\UseCases\Comment\Query\GetCommentsByCompanyId;

class GetCommentsByCompanyIdQuery
{
    public function __construct(public int $companyId) {}
}
