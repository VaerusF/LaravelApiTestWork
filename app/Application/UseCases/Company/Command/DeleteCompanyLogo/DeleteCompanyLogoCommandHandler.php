<?php

namespace App\Application\UseCases\Company\Command\DeleteCompanyLogo;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommand;
use App\Application\UseCases\Files\Command\DeleteFile\DeleteFileCommandHandler;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class DeleteCompanyLogoCommandHandler
{
    private ICompanyRepository $companyRepository;
    private DeleteFileCommandHandler $deleteFileCommandHandler;
    public function __construct(ICompanyRepository $companyRepository, DeleteFileCommandHandler $deleteFileCommandHandler)
    {
        $this->companyRepository = $companyRepository;
        $this->deleteFileCommandHandler = $deleteFileCommandHandler;
    }

    public function handle(DeleteCompanyLogoCommand $command): bool|ErrorDto
    {
        if (!$this->companyRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "Company with id $command->id not found"], 404);
        };

        $company = $this->companyRepository->findById($command->id);

        if ($company->getLogoId() !== null) {
            $deleteResult = $this->deleteFileCommandHandler->handle(new DeleteFileCommand($company->getLogoId()));

            if ($deleteResult instanceof ErrorDto) {
                return new ErrorDto(['1' => $deleteResult]);
            }

            $this->companyRepository->deleteLogo($company->getCompanyId());
        }

        return true;
    }
}
