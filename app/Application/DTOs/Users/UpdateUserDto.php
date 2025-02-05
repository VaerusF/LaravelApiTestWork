<?php

namespace App\Application\DTOs\Users;

use Illuminate\Http\UploadedFile;

class UpdateUserDto
{
    public function __construct(
        public string $firstname,
        public string $lastname,
        public string $phone,
        public ?UploadedFile $avatar,
    )
    {
    }
}
