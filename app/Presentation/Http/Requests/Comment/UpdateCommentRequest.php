<?php

namespace App\Presentation\Http\Requests\Comment;

use App\Application\DTOs\Comment\UpdateCommentDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function rules(): array {
        return [
            'user_id' => 'required|integer|exists:users,user_id',
            'company_id' => 'required|integer|exists:company,company_id',
            'content'    => 'required|string|min:150|max:550',
            'rating'     => 'required|numeric|integer|min:1|max:10'
        ];
    }

    public function toDto(): UpdateCommentDto {
        return new UpdateCommentDto(
            $this->input('user_id'),
            $this->input('company_id'),
            $this->input('content'),
            $this->input('rating')
        );
    }
}
