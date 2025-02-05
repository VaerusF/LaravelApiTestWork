<?php

namespace App\Application\UseCases\Files\Command\UploadUserAvatar;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Core\Domain\Enums\FileTypes;
use App\Infrastructure\Services\IFileDiskManagerService;

class UploadUserAvatarCommandHandler
{
    private IFilesRepository $filesRepository;
    private IFileDiskManagerService $filesUploaderService;
    public function __construct(IFilesRepository $filesRepository, IFileDiskManagerService $filesUploaderService)
    {
        $this->filesRepository = $filesRepository;
        $this->filesUploaderService = $filesUploaderService;
    }

    public function handle(UploadUserAvatarCommand $command): int|ErrorDto {
        $file = $command->avatarFile;

        $fileUploadResult = $this->filesUploaderService->uploadFile($file, FileTypes::Avatar->value);

        if (is_array($fileUploadResult)) {
            return new ErrorDto($fileUploadResult);
        }

        return $this->filesRepository->create(FileTypes::Avatar, $fileUploadResult);
    }
}
