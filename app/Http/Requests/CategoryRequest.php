<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CategoryRequest extends FormRequest
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
        Log::info($this->all());
        return [
            'name' => 'required|string|min:6|max:255|unique:categories,name,'. $this->input('id') .',id,deleted_at,NULL',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên Category không được bỏ trống',
            'name.string' => 'Tên Category phải là kiểu chuỗi',
            'name.min' => 'Tên Category phải có ít nhất 6 kí tự',
            'name.unique' => 'Tên Category đã được sử dụng',
        ];
    }
}
