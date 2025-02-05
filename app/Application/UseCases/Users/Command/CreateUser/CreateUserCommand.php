<?php

namespace App\Application\UseCases\Users\Command\CreateUser;

use App\Application\DTOs\Users\CreateUserDto;

class CreateUserCommand
{
    public function __construct(public CreateUserDto $dto) {}
}
