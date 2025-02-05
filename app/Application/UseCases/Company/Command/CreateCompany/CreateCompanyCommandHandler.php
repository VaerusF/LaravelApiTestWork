<?php

namespace App\Application\UseCases\Company\Command\CreateCompany;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\UploadCompanyLogo\UploadCompanyLogoCommand;
use App\Application\UseCases\Files\Command\UploadCompanyLogo\UploadCompanyLogoCommandHandler;
use App\Core\Domain\Entities\Company\Company;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class CreateCompanyCommandHandler
{
    private ICompanyRepository $companyRepository;
    private UploadCompanyLogoCommandHandler $uploadCompanyLogoCommand;

    public function __construct(ICompanyRepository $companyRepository, UploadCompanyLogoCommandHandler $uploadCompanyLogoCommand)
    {
        $this->companyRepository = $companyRepository;
        $this->uploadCompanyLogoCommand = $uploadCompanyLogoCommand;
    }

    public function handle(CreateCompanyCommand $command): int|ErrorDto {
        $dto = $command->dto;

        $fileId = $this->uploadCompanyLogoCommand->handle(new UploadCompanyLogoCommand($dto->logo));

        if ($fileId instanceof ErrorDto) {
            return $fileId;
        }

        $company = new Company($dto->name, $dto->description, $fileId);

        return $this->companyRepository->create($company);
    }
}
