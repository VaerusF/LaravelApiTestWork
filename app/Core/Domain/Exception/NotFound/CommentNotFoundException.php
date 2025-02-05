<?php

namespace App\Core\Domain\Exception\NotFound;

use App\Core\Domain\Exception\CustomException;

class CommentNotFoundException extends CustomException
{
    public function __construct() {
        parent::__constructWithMessage(404, "Comment not found");
    }
}
