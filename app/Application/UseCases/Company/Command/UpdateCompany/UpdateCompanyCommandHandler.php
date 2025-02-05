<?php

namespace App\Application\UseCases\Company\Command\UpdateCompany;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommand;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommandHandler;
use App\Application\UseCases\Files\Command\UploadCompanyLogo\UploadCompanyLogoCommand;
use App\Application\UseCases\Files\Command\UploadCompanyLogo\UploadCompanyLogoCommandHandler;
use App\Core\Domain\Entities\Company\Company;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class UpdateCompanyCommandHandler
{
    private ICompanyRepository $companyRepository;
    private UploadCompanyLogoCommandHandler $uploadCompanyLogoCommand;
    private DeleteFileCommandHandler $deleteFileCommandHandler;

    public function __construct(
        ICompanyRepository $companyRepository,
        UploadCompanyLogoCommandHandler $uploadCompanyLogoCommand,
        DeleteFileCommandHandler $deleteFileCommandHandler
    )
    {
        $this->companyRepository = $companyRepository;
        $this->uploadCompanyLogoCommand = $uploadCompanyLogoCommand;
        $this->deleteFileCommandHandler = $deleteFileCommandHandler;
    }

    public function handle(UpdateCompanyCommand $command) : bool|ErrorDto {
        if (!$this->companyRepository->tryFindById($command->companyId)) {
            return new ErrorDto(['1' => 'Company not found'], 404);
        };

        $companyOldState = $this->companyRepository->findById($command->companyId);

        $dto = $command->dto;

        $fileId = null;

        if ($dto->logo !== null) {
            if ($companyOldState->getLogoId() !== null) {
                $deleteResult = $this->deleteFileCommandHandler->handle(new DeleteFileCommand($companyOldState->getLogoId()));

                if (is_array($deleteResult)) {
                    return new ErrorDto(['1' => $deleteResult]);
                }
            }

            $fileId = $this->uploadCompanyLogoCommand->handle(new UploadCompanyLogoCommand($dto->logo));

            if ($fileId instanceof ErrorDto) {
                return $fileId;
            }
        }

        $companyNewState = new Company($dto->name, $dto->description, $fileId);
        $companyNewState->setCompanyId($command->companyId);

        return $this->companyRepository->update($companyNewState);
    }
}
