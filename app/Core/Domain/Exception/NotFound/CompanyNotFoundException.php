<?php

namespace App\Core\Domain\Exception\NotFound;

use App\Core\Domain\Exception\CustomException;

class CompanyNotFoundException extends CustomException
{
    public function __construct() {
        parent::__constructWithMessage(404, "Company not found");
    }
}
