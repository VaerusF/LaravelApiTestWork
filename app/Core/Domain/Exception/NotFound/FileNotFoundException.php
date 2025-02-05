<?php

namespace App\Core\Domain\Exception\NotFound;

use App\Core\Domain\Exception\CustomException;

class FileNotFoundException extends CustomException
{
    public function __construct() {
        parent::__constructWithMessage(404, "File not found");
    }
}
