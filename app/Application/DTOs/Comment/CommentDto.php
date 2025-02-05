<?php

namespace App\Application\DTOs\Comment;

class CommentDto
{
    public function __construct(
        public int $commentId,
        public int $userId,
        public int $companyId,
        public string $content,
        public int $rating,
    )
    {
    }
}
