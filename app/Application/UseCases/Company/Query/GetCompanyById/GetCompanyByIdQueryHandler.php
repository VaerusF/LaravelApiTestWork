<?php

namespace App\Application\UseCases\Company\Query\GetCompanyById;

use App\Application\DTOs\Company\CompanyDto;
use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class GetCompanyByIdQueryHandler
{
    private ICompanyRepository $companyRepository;
    public function __construct(ICompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function handle(GetCompanyByIdQuery $query): CompanyDto|ErrorDto {
        if (!$this->companyRepository->tryFindById($query->id)) {
            return new ErrorDto(['1' => "Company with id $query->id not found"], 404);
        };

        $company = $this->companyRepository->findById($query->id);

        return new CompanyDto(
            $company->getCompanyId(),
            $company->getCompanyName(),
            $company->getCompanyDescription(),
            $company->getLogoId()
        );
    }
}
