<?php

namespace App\Presentation\Http\Requests\User;

use App\Application\DTOs\Users\CreateUserDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules(): array {
        return [
            'firstname'     => 'required|string|min:4|max:39',
            'lastname'    => 'required|string|min:4|max:39',
            'phone' => 'required|string|regex:/^\+7\d{10}$/',
            'avatar'   => 'required|image|mimes:png,jpg|max:2048',
        ];
    }

    public function toDto(): CreateUserDto {
        return new CreateUserDto(
            $this->input('firstname'),
            $this->input('lastname'),
            $this->input('phone'),
            $this->file('avatar'),
        );
    }
}
