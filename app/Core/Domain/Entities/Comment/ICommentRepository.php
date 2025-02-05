<?php

namespace App\Core\Domain\Entities\Comment;

interface ICommentRepository
{
    public function create(Comment $comment): int;
    public function tryFindById(int $id): bool;
    public function findById(int $id): Comment;
    /**
     * @return Comment[]
     */
    public function findByCompanyId(int $companyId): array;
    public function update(Comment $commentNewState): bool;
    public function delete(int $id): void;
}
