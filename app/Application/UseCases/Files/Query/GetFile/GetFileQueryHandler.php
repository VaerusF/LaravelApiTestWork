<?php

namespace App\Application\UseCases\Files\Query\GetFile;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Infrastructure\Services\IFileDiskManagerService;

class GetFileQueryHandler
{
    private IFilesRepository $filesRepository;
    private IFileDiskManagerService $fileDiskManager;

    public function __construct(IFilesRepository $filesRepository, IFileDiskManagerService $fileDiskManager)
    {
        $this->filesRepository = $filesRepository;
        $this->fileDiskManager = $fileDiskManager;
    }

    public function handle(GetFileQuery $query): string|ErrorDto
    {
        if (!$this->filesRepository->tryFindById($query->id)) {
            return new ErrorDto(['1' => "File with id $query->id not found"], 404);
        };

        $file = $this->filesRepository->findById($query->id);

        $filePath = $this->fileDiskManager->combineFilePath($file->getFileType()->value, $file->getFileName());

        return $this->fileDiskManager->CheckFile($file->getFileType()->value, $file->getFileName()) ?
            $filePath : new ErrorDto(['1' => "File with id $query->id not found"], 404);
    }
}
