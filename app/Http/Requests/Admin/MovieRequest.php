<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    
    
    public function rules(): array
    {
        $rule = [
            'm_Image'=>'required|mimes:jpeg,jpg,png,gif',
            'm_Poster'=>'required|mimes:jpeg,jpg,png,gif',
            'm_Title'=>'required',
            'm_Director'=>'required',
            'm_ReleaseYear'=>'required|digits:4',
            'm_Description'=>'required',
            'genres'=>'required'
        ];
        if(session('m_id')){
            unset($rule['m_Image']);
            unset($rule['m_Poster']);
        }
        return $rule;
    }

    public function messages(): array
    {
        $message = [
            'm_Image.required'=>'Bắt buộc chọn một ảnh',
            'm_Image.mimes'=>'Ảnh phải có định dạng đuôi: jpeg,jpg,png,gif',
            'm_Poster.required'=>'Bắt buộc chọn một ảnh',
            'm_Poster.mimes'=>'Ảnh phải có định dạng đuôi: jpeg,jpg,png,gif',
            'm_Title.required'=>'Tên phim bắt buộc nhập',
            'm_Director.required'=>'Tên đạo diễn bắt buộc nhập',
            'm_ReleaseYear.required'=>'Năm công chiếu bắt buộc nhập',
            'm_ReleaseYear.digits'=>'Năm công chiếu phải là 1 số có 4 chữ số',
            'm_Description.required'=>'Mô tả bắt buộc nhập',
            'genres.required'=>'Vui lòng chọn thể loại phim'
        ];
        return $message;
    }
}
