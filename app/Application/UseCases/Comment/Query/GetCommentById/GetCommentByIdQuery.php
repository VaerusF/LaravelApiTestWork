<?php

namespace App\Application\UseCases\Comment\Query\GetCommentById;

class GetCommentByIdQuery
{
    public function __construct(public int $id) {}
}
