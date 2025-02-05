<?php

namespace App\Application\UseCases\Files\Command\DeleteFile;

class DeleteFileCommand
{
    public function __construct(public int $id)
    {
    }
}
