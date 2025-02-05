<?php

namespace App\Application\UseCases\Comment\Command\CreateComment;

use App\Application\DTOs\Comment\CreateCommentDto;

class CreateCommentCommand
{
    public function __construct(public CreateCommentDto $dto)
    {
    }
}
