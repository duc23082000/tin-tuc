<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
        if($this->url() == route('admin.change')){
            $user = Auth::guard('admins')->user();
        }
        if($this->url() == route('account.change')){
            $user = Auth::guard('web')->user();
        }
        return [
            'current_password' => [function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail(__('Mật khẩu hiện tại không chính xác.'));
                }
            }],
            'password' => 'required|min:6|max:255|string|same:cfpassword',
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
