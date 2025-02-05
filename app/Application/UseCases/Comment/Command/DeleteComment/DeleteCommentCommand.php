<?php

namespace App\Application\UseCases\Comment\Command\DeleteComment;

class DeleteCommentCommand
{
    public function __construct(public int $id) {}
}
