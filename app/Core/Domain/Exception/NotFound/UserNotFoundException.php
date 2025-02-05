<?php

namespace App\Core\Domain\Exception\NotFound;

use App\Core\Domain\Exception\CustomException;

class UserNotFoundException extends CustomException
{
    public function __construct() {
        parent::__constructWithMessage(404, "User not found");
    }
}
