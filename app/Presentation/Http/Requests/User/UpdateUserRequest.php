<?php

namespace App\Presentation\Http\Requests\User;

use App\Application\DTOs\Users\UpdateUserDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array {
        return [
            'firstname'     => 'required|string|min:4|max:39',
            'lastname'    => 'required|string|min:4|max:39',
            'phone' => 'required|string|regex:/^\+7\d{10}$/',
            'avatar'   => 'nullable|image|mimes:png,jpg|max:2048',
        ];
    }

    public function toDto(): UpdateUserDto {
        return new UpdateUserDto(
            $this->input('firstname'),
            $this->input('lastname'),
            $this->input('phone'),
            $this->file('avatar'),
        );
    }
}
