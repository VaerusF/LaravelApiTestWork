<?php

namespace App\Application\DTOs\Users;

class UserDto
{
    public function __construct(
        public int    $id,
        public string $firstname,
        public string $lastname,
        public string $phone,
        public ?int   $avatarId) {
    }
}
