<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'collum' => 'in:posts.id,posts.title,posts.content,posts.craeted_at,posts.modified_at,users.email,users2.email,posts.posted_at',
            'sort' => 'in:asc,desc'
        ];
    }
}