<?php

namespace App\Core\Domain\Entities\Company;

class Company
{
    private int $companyId;
    private string $companyName;
    private string $companyDescription;
    private ?int $logoId;

    public function __construct(string $companyName, string $companyDescription, ?int $logoId)
    {
        $this->companyName = $companyName;
        $this->companyDescription = $companyDescription;
        $this->logoId = $logoId;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function setCompanyId(int $companyId): void
    {
        $this->companyId = $companyId;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getCompanyDescription(): string
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription(string $companyDescription): void
    {
        $this->companyDescription = $companyDescription;
    }

    public function getLogoId(): ?int
    {
        return $this->logoId;
    }

    public function setLogoId(?int $logoId): void
    {
        $this->logoId = $logoId;
    }
}
