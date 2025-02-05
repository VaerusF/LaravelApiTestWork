<?php

namespace App\Presentation\Http\Requests\Comment;

use App\Application\DTOs\Comment\CreateCommentDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    public function rules(): array {
        return [
            'user_id' => 'required|integer|exists:users,user_id',
            'company_id' => 'required|integer|exists:company,company_id',
            'content'    => 'required|string|min:150|max:550',
            'rating'     => 'required|numeric|integer|min:1|max:10'
        ];
    }

    public function toDto(): CreateCommentDto {
        return new CreateCommentDto(
            $this->input('user_id'),
            $this->input('company_id'),
            $this->input('content'),
            $this->input('rating')
        );
    }
}
