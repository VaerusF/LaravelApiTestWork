<?php

namespace App\Core\Domain\Entities\Comment;

class Comment
{
    private int $commentId;
    private int $userId;
    private int $companyId;
    private string $content;
    private int $rating;

    public function __construct(int $userId, int $companyId, string $content, int $rating)
    {
        $this->userId = $userId;
        $this->companyId = $companyId;
        $this->content = $content;
        $this->rating = $rating;
    }

    public function getCommentId(): int
    {
        return $this->commentId;
    }

    public function setCommentId(int $commentId): void
    {
        $this->commentId = $commentId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function setCompanyId(int $companyId): void
    {
        $this->companyId = $companyId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
}
