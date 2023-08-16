<?php

namespace App\Http\Requests;

use App\Enums\PostStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
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
        if($this->input('status') == PostStatusEnum::Private){
            $rules['posted_at'][] = 'after:yesterday';
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
            'posted_at.after' => 'Nếu status là private thì ngày đăng phải bắt buộc phải lớn hơn hoặc bằng hôm nay',
        ];
    }

    public function failedValidation(Validator $validator){
        if(session()->has('upload'.$this->user()->id)){
            foreach(session()->get('upload'.$this->user()->id) as $fileName){
                Storage::delete('public/images/'.$fileName);
            }
        }
        parent::failedValidation($validator);
    }
}
