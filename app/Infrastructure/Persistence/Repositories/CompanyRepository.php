<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Core\Domain\Entities\Company\Company;
use App\Core\Domain\Entities\Company\ICompanyRepository;
use App\Core\Domain\Exception\NotFound\CompanyNotFoundException;
use App\Infrastructure\Persistence\Models\CompanyModel;

class CompanyRepository implements ICompanyRepository
{

    public function create(Company $company): int
    {
        $companyModel = new CompanyModel();

        $companyModel->name = $company->getCompanyName();
        $companyModel->description = $company->getCompanyDescription();
        $companyModel->logo_id = $company->getLogoId();

        $companyModel->save();

        return $companyModel->company_id;
    }

    public function tryFindById(int $id): bool
    {
        $companyModel = CompanyModel::find($id);

        if ($companyModel === null) {
            return false;
        }

        return true;
    }

    /**
     * @throws CompanyNotFoundException
     */
    public function findById(int $id): Company
    {
        $companyModel = CompanyModel::findOr($id, function () {
            throw new CompanyNotFoundException();
        });

        $company = new Company($companyModel->name, $companyModel->description, $companyModel->logo_id);
        $company->setCompanyId($companyModel->company_id);

        return $company;
    }

    /**
     * @return ?array{Company: Company, rating: float}
     */
    public function getCompanyRating(int $companyId): ?array
    {
        $result = CompanyModel::join('comments', 'company.company_id', '=', 'comments.company_id')
        ->where('company.company_id', $companyId)
            ->select('company.*')
            ->selectRaw('COALESCE(AVG(comments.rating), 0) as rating')
            ->groupBy('company.company_id')
            ->first();

        if ($result === null) {
            return null;
        }

        $company = new Company(
            $result->name,
            $result->description,
            $result->logo_id,
        );
        $company->setCompanyId($result->company_id);

        return ['company' => $company, 'rating' => (float) $result->rating];
    }

    /**
     * @return array<int, array{Company: Company, rating: float}>
     */
    public function getTopCompanyByRating(): array
    {
        return CompanyModel::select('company.*')
            ->leftJoin('comments', 'company.company_id', '=', 'comments.company_id')
            ->selectRaw('COALESCE(AVG(comments.rating), 0) as rating')
            ->groupBy('company.company_id')
            ->orderByDesc('rating')
            ->limit(10)
            ->get()
            ->map(function (CompanyModel $companyModel) {
                $company = new Company($companyModel->name, $companyModel->description, $companyModel->logo_id);
                $company->setCompanyId($companyModel->company_id);

                return ['company' => $company, 'rating' => (float) $companyModel->rating];
            })
            ->toArray();
    }

    /**
     * @throws CompanyNotFoundException
     */
    public function update(Company $companyNewState): bool
    {
        $companyOld = CompanyModel::findOr($companyNewState->getCompanyId(), function () {
            throw new CompanyNotFoundException();
        });

        $companyOld->name = $companyNewState->getCompanyName();
        $companyOld->description = $companyNewState->getCompanyDescription();

        if ($companyNewState->getLogoId() !== null) {
            $companyOld->logo_id = $companyNewState->getLogoId();
        }

        $companyOld->save();

        return true;
    }

    /**
     * @throws CompanyNotFoundException
     */
    public function deleteLogo(int $companyId): bool
    {
        $companyOld = CompanyModel::findOr($companyId, function () {
            throw new CompanyNotFoundException();
        });

        $companyOld->logo_id = null;

        $companyOld->save();

        return true;
    }

    /**
     * @throws CompanyNotFoundException
     */
    public function delete(int $id): void
    {
        if (!$this->tryFindById($id)) {
            throw new CompanyNotFoundException();
        };

        CompanyModel::destroy($id);
    }
}
