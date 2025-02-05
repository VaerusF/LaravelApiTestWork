<?php

namespace App\Application\UseCases\Comment\Command\UpdateComment;

use App\Application\DTOs\Comment\UpdateCommentDto;

class UpdateCommentCommand
{
    public function __construct(public int $commentId, public UpdateCommentDto $dto)
    {

    }
}
