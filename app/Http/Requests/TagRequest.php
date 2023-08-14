<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'name' => 'required|string|min:6|max:255|unique:tags,name,'. $this->input('id') .',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên Tag không được bỏ trống',
            'name.string' => 'Tên Tag phải là kiểu chuỗi',
            'name.min' => 'Tên Tag phải có ít nhất 6 kí tự',
            'name.unique' => 'Tên Tag đã được sử dụng',
        ];
    }
}
