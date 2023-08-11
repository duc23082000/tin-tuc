<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassRequest extends FormRequest
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
            'password' => 'required|string|min:6|max:255|same:cfpassword'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password phải có ít nhất 6 kí tự',
            'password.same' => 'Password không trùng khớp',
        ];
    }
}
