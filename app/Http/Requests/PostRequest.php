<?php

namespace App\Http\Requests;

use App\Enums\PostStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|min:8|max:255',
            'status' => ['required', Rule::in(PostStatusEnum::asArray())],
            'category' => 'required|exists:categories,id,deleted_at,NULL',
            'posted_at' => ['required', 'date'],
        ];
        if($this->input('tags')){
            $rules['tags.*'] = 'exists:tags,id,deleted_at,NULL';
        }
        if($this->input('status') == PostStatusEnum::PubLic){
            $rules['posted_at'][] = 'before_or_equal:today';
        }
        if($this->file('image')){
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
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
            'status.required' => 'Trạng thái không được bỏ trống',
            'status.in' => 'Trạng thái không hợp lệ',
            'category.required' => 'Vui lòng chọn dữ liệu',
            'category.exists' => 'Giá trị phải khớp với giá trị của bảng categories',
            'tags.*.exist' => 'Giá trị không hợp lệ',
            'posted_at.required' => 'Ngày đăng không được để trống',
            'posted_at.date' => 'Ngày đăng phải là kiểu ngày',
            'posted_at.before_or_equal' => 'Không thể public bài đăng của tương lai',
            'image.mimes' => 'Ảnh phải là có định dạng jpeg, png, jpg, gif và nhỏ hơn 5MB',
            'image.max' => 'Ảnh phải là có định dạng jpeg, png, jpg, gif và nhỏ hơn 5MB',
            'image.image' => 'Ảnh phải là có định dạng jpeg, png, jpg, gif và nhỏ hơn 5MB',
        ];
    }

}
