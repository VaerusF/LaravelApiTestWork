<?php

namespace App\Application\UseCases\Company\Command\DeleteCompanyLogo;

class DeleteCompanyLogoCommand
{
    public function __construct(public int $id) {}
}
