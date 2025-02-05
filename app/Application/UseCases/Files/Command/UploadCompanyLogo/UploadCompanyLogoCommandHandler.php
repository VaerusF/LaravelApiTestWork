<?php

namespace App\Application\UseCases\Files\Command\UploadCompanyLogo;

use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\File\IFilesRepository;
use App\Core\Domain\Enums\FileTypes;
use App\Infrastructure\Services\IFileDiskManagerService;

class UploadCompanyLogoCommandHandler
{
    private IFilesRepository $filesRepository;
    private IFileDiskManagerService $filesUploaderService;
    public function __construct(IFilesRepository $filesRepository, IFileDiskManagerService $filesUploaderService)
    {
        $this->filesRepository = $filesRepository;
        $this->filesUploaderService = $filesUploaderService;
    }

    public function handle(UploadCompanyLogoCommand $command): int|ErrorDto {
        $file = $command->logoFile;

        $file_upload_result = $this->filesUploaderService->uploadFile($file, FileTypes::CompanyLogo->value);

        if (is_array($file_upload_result)) {
            return new ErrorDto($file_upload_result);
        }

        return $this->filesRepository->create(FileTypes::CompanyLogo, $file_upload_result);
    }
}
