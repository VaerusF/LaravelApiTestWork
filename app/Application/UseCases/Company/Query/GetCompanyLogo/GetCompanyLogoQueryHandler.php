<?php

namespace App\Application\UseCases\Company\Query\GetCompanyLogo;

use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Files\Query\GetFile\GetFileQuery;
use App\Application\UseCases\Files\Query\GetFile\GetFileQueryHandler;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class GetCompanyLogoQueryHandler
{
    private ICompanyRepository $companyRepository;
    private GetFileQueryHandler $getFileQueryHandler;

    public function __construct(ICompanyRepository $companyRepository, GetFileQueryHandler $getFileQueryHandler)
    {
        $this->companyRepository = $companyRepository;
        $this->getFileQueryHandler = $getFileQueryHandler;
    }

    public function handle(GetCompanyLogoQuery $query): string|ErrorDto
    {
        if (!$this->companyRepository->tryFindById($query->companyId)) {
            return new ErrorDto(['1' => "Company with id $query->companyId not found"], 404);
        };

        $company = $this->companyRepository->findById($query->companyId);

        if ($company->getLogoId() === null) {
            return new ErrorDto(['1' => "CompanyLogo not found"], 404);
        }

        return $this->getFileQueryHandler->handle(new GetFileQuery($company->getLogoId()));
    }
}
