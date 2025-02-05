<?php

namespace App\Application\UseCases\Users\Query\GetUserById;

class GetUserByIdQuery
{
    public function __construct(public int $id) {}
}
