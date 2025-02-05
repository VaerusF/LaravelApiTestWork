<?php

namespace App\Application\UseCases\Company\Command\DeleteCompany;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Company\Command\DeleteCompanyLogo\DeleteCompanyLogoCommand;
use App\Application\UseCases\Company\Command\DeleteCompanyLogo\DeleteCompanyLogoCommandHandler;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class DeleteCompanyCommandHandler
{
    private ICompanyRepository $companyRepository;
    private DeleteCompanyLogoCommandHandler $deleteCompanyLogoCommandHandler;
    public function __construct(ICompanyRepository $companyRepository, DeleteCompanyLogoCommandHandler $deleteCompanyLogoCommandHandler)
    {
        $this->companyRepository = $companyRepository;
        $this->deleteCompanyLogoCommandHandler = $deleteCompanyLogoCommandHandler;
    }

    public function handle(DeleteCompanyCommand $command): bool|ErrorDto
    {
        if (!$this->companyRepository->tryFindById($command->id)) {
            return new ErrorDto(['1' => "Company with id $command->id not found"], 404);
        };

        $this->deleteCompanyLogoCommandHandler->handle(new DeleteCompanyLogoCommand($command->id));

        $this->companyRepository->delete($command->id);

        return true;
    }
}
