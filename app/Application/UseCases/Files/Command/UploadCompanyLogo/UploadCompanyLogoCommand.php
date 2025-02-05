<?php

namespace App\Application\UseCases\Files\Command\UploadCompanyLogo;

use Illuminate\Http\UploadedFile;

class UploadCompanyLogoCommand
{
    public function __construct(public UploadedFile $logoFile)
    {
    }
}
