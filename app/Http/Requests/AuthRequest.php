<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        if($this->url() == route('account.register') || $this->url() == route('admin.user.api.create') || $this->url() == route('admin.user.api.update', $this->input('id', ''))){
            $table = 'users';
        }
        if($this->url() == route('admin.author.api.create') || $this->url() == route('admin.author.api.update', $this->input('id', ''))){
            $table = 'admins';
        }
        
        return [
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:'.$table.',email,'. $this->input('id') .',id',
            'password' => 'required|string|min:6|max:50',
            'cfpassword' => 'same:password',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Tên người dùng không được bỏ trống',
            'username.min' => 'Tên người dùng phải có ít nhất 3 kí tự',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email phải là kiểu email',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password phải có ít nhất 6 kí tự',
            'cfpassword.same' => 'Password không trùng khớp',
        ];
    }
}
