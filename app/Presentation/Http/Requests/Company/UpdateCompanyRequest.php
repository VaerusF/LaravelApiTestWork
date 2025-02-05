<?php

namespace App\Presentation\Http\Requests\Company;

use App\Application\DTOs\Company\UpdateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function rules(): array {
        return [
            'name'     => 'required|string|min:4|max:39',
            'description'    => 'required|string|min:150|max:400',
            'logo'   => 'nullable|image|mimes:png|max:3072',
        ];
    }

    public function toDto(): UpdateCompanyDto {
        return new UpdateCompanyDto(
            $this->input('name'),
            $this->input('description'),
            $this->file('logo'),
        );
    }
}
