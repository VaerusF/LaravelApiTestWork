<?php

namespace App\Application\DTOs\Comment;

class CreateCommentDto
{
    public function __construct(
        public int    $userId,
        public int    $companyId,
        public string $content,
        public int    $rating,
    )
    {
    }
}
