<?php

namespace App\Core\Domain\Entities\File;

use App\Core\Domain\Enums\FileTypes;

interface IFilesRepository
{
    public function create(FileTypes $file_type, string $file_name): int;
    public function tryFindById(int $id): bool;
    public function findById(int $id): File;
    public function delete(int $id): void;
}
