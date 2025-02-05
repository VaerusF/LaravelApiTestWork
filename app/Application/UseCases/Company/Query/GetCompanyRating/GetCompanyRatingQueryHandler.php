<?php

namespace App\Application\UseCases\Company\Query\GetCompanyRating;

use App\Application\DTOs\Company\CompanyDto;
use App\Application\DTOs\Company\CompanyRating;
use App\Application\DTOs\ErrorDto;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class GetCompanyRatingQueryHandler
{
    private ICompanyRepository $companyRepository;
    public function __construct(ICompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function handle(GetCompanyRatingQuery $query): CompanyRating|ErrorDto {
        if (!$this->companyRepository->tryFindById($query->id)) {
            return new ErrorDto(['1' => "Company with id $query->id not found"], 404);
        };

        $ratingData = $this->companyRepository->getCompanyRating($query->id);
        if ($ratingData === null) {
            return new ErrorDto(['1' => "Company rating for id $query->id not found"], 404);
        }

        $company = $ratingData['company'];

        return new CompanyRating(
            new CompanyDto(
                $company->getCompanyId(),
                $company->getCompanyName(),
                $company->getCompanyDescription(),
                $company->getLogoId()),
            round($ratingData['rating'],2)
        );
    }
}
