<?php

namespace App\Application\UseCases\Users\Command\DeleteUserAvatar;

class DeleteUserAvatarCommand
{
    public function __construct(public int $id) {}
}
