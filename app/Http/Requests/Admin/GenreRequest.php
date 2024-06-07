<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
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
        $unique = 'unique:genres';
        if(session('g_id')){
            $g_id = session('g_id');
            $unique = 'unique:genres,g_Name,'.$g_id;
        }
        return [
            'g_Name'=>'required|'.$unique
        ];
    }

    public function messages(): array
    {
        $message = [
            'g_Name.required'=>'Thể loại phim không được để trống',
            'g_Name.unique'=>'Thể loại phim đã tồn tại'
        ];
       
        return $message;
    }
}
