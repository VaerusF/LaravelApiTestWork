<?php

namespace App\Application\UseCases\Files\Command\UploadUserAvatar;

use Illuminate\Http\UploadedFile;

class UploadUserAvatarCommand
{
    public function __construct(public UploadedFile $avatarFile)
    {
    }
}
