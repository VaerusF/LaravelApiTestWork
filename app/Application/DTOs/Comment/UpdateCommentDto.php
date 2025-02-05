<?php

namespace App\Application\DTOs\Comment;

class UpdateCommentDto
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
