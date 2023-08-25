<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if($this->input('users.*')){
            
            $this->merge([
                'user' => handle_array_users($this->users)["user"],
                'author' => handle_array_users($this->users)["author"],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|min:8|max:255',
            'users' => 'required',
            'author' => [],
            'user' => [],
        ];
        
        if($this->input('users')){
            if(empty($this->input('user'))){
                $rules['author'][] = 'required';
            }
    
            if(empty($this->input('author'))){
                $rules['user'][] = 'required';
            }
    
            if($this->input('user')){
                $rules['user'][] = 'exists:users,id,deleted_at,NULL';
            }
    
            if($this->input('author')){
                $rules['author'][] = 'exists:admins,id,deleted_at,NULL';
            }
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được bỏ trống',
            'title.string' => 'Tiêu đề phải là kiểu chuỗi',
            'title.min' => 'Tiêu đề phải có ít nhất 8 kí tự',
            'title.max' => 'Tiêu đề chỉ được phép tối đa 255 kí tự',
            'users.required' => 'Vui lòng chọn người nhận thông báo',
            'user.required' => 'Giá trị người dùng không tồn tại',
            'author.required' => 'Giá trị tác giả không tồn tại',
            'user.exists' => 'Giá trị không hợp lệ',
            'author.exists' => 'Giá trị không hợp lệ',
        ];
    }

    // protected function failedValidation(Validator $validator) : void
    // {
        
    // }

    
}
