<?php

namespace App\Application\UseCases\Users\Command\DeleteUser;

class DeleteUserCommand
{
    public function __construct(public int $id) {}
}
