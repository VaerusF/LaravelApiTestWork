<?php

namespace App\Application\DTOs\Company;

use Illuminate\Http\UploadedFile;

class UpdateCompanyDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ?UploadedFile $logo,
    )
    {
    }
}
