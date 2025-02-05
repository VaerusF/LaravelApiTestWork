<?php

namespace App\Core\Domain\Entities\Company;

interface ICompanyRepository
{
    public function create(Company $company): int;
    public function tryFindById(int $id): bool;
    public function findById(int $id): Company;
    /**
     * @return ?array{company: Company, rating: float}
     */
    public function getCompanyRating(int $companyId): ?array;
    /**
     * @return array<int, array{company: Company, rating: float}>
     */
    public function getTopCompanyByRating(): array;
    public function update(Company $companyNewState): bool;
    public function deleteLogo(int $companyId): bool;
    public function delete(int $id): void;
}
