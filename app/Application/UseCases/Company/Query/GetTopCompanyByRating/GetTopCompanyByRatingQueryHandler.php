<?php

namespace App\Application\UseCases\Company\Query\GetTopCompanyByRating;

use App\Application\DTOs\Company\CompanyDto;
use App\Application\DTOs\Company\CompanyRating;
use App\Application\DTOs\ErrorDto;
use App\Application\UseCases\Company\Query\GetCompanyRating\GetCompanyRatingQuery;
use App\Core\Domain\Entities\Company\ICompanyRepository;

class GetTopCompanyByRatingQueryHandler
{
    private ICompanyRepository $companyRepository;
    public function __construct(ICompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @return CompanyRating[]|ErrorDto
     */
    public function handle(GetTopCompanyByRatingQuery $query): array|ErrorDto {
        $ratingData = $this->companyRepository->getTopCompanyByRating();

        return collect($ratingData)->map(function (array $data) {
            $company = $data['company'];

            return new CompanyRating(
                new CompanyDto(
                    $company->getCompanyId(),
                    $company->getCompanyName(),
                    $company->getCompanyDescription(),
                    $company->getLogoId()),
                round($data['rating'],2)
            );
        })->toArray();
    }
}
