<?php

namespace App\Application\DTOs\Company;

use Illuminate\Http\UploadedFile;

class CompanyDto
{
    public function __construct(
        public int $companyId,
        public string $name,
        public string $description,
        public ?int $logoId,
    )
    {
    }
}
