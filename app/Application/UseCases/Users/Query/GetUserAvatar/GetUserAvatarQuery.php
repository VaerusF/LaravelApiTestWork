<?php

namespace App\Application\UseCases\Users\Query\GetUserAvatar;

class GetUserAvatarQuery
{
    public function __construct(public int $userId)
    {
    }
}
