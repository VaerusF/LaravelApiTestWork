<?php

namespace App\Application\UseCases\Users\Command\UpdateUser;

use App\Application\DTOs\Users\UpdateUserDto;

class UpdateUserCommand
{
    public function __construct(public int $userId, public UpdateUserDto $dto) {}
}
