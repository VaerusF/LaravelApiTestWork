<?php

namespace App\Core\Domain\Entities\User;

interface IUserRepository
{
    public function create(User $user): int;
    public function tryFindById(int $id): bool;
    public function findById(int $id): User;
    public function update(User $userNewState): bool;
    public function deleteAvatar(int $userId): bool;
    public function delete(int $id): void;
}
