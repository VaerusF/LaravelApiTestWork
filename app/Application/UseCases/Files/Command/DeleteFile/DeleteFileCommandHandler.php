<?php

namespace App\Application\UseCases\Files\Command\DeleteFile;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Infrastructure\Services\IFileDiskManagerService;

class DeleteFileCommandHandler
{
    private IFilesRepository $filesRepository;
    private IFileDiskManagerService $fileDiskManager;

    public function __construct(IFilesRepository $filesRepository, IFileDiskManagerService $fileDiskManager)
    {
        $this->filesRepository = $filesRepository;
        $this->fileDiskManager = $fileDiskManager;
    }

    public function handle(DeleteFileCommand $command): bool|ErrorDto {
        if (!$this->filesRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "File with id $command->id not found"], 404);
        };

        $file = $this->filesRepository->findById($command->id);

        $resultFileDelete = $this->fileDiskManager->deleteFile($file->getFileType()->value, $file->getFileName());

        if (!$resultFileDelete) {
            return new ErrorDto(['1' => "File with id $command->id was not deleted"]);
        }

        $this->filesRepository->delete($file->getFileId());

        return true;
    }
}
