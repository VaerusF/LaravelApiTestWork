<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Core\Domain\Entities\File\File;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Core\Domain\Enums\FileTypes;
use App\Core\Domain\Exception\NotFound\FileNotFoundException;
use App\Infrastructure\Persistence\Models\FileModel;

class FilesRepository implements IFilesRepository
{

    public function create(FileTypes $file_type, string $file_name): int
    {
        $fileModel = New FileModel();

        $fileModel->file_type = $file_type;
        $fileModel->file_name = $file_name;

        $fileModel->save();

        return $fileModel->file_id;
    }

    public function tryFindById(int $id): bool
    {
        $companyModel = FileModel::find($id);

        if ($companyModel === null) {
            return false;
        }

        return true;
    }

    /**
     * @throws FileNotFoundException
     */
    public function findById(int $id): File
    {
        $fileModel = FileModel::findOr($id, function () {
            throw new FileNotFoundException();
        });

        return new File($fileModel->file_id, $fileModel->file_type, $fileModel->file_name);
    }

    /**
     * @throws FileNotFoundException
     */
    public function delete(int $id): void
    {
        if (!$this->tryFindById($id)) {
            throw new FileNotFoundException();
        };

        FileModel::destroy($id);
    }
}
