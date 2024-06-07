<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        
        $unique = 'unique:roles,r_Name';
        if(session('r_id')){
            $r_id = session('r_id');
            $unique = 'unique:roles,r_Name,'.$r_id;
        }
        return [
            'r_Name'=>'required|'.$unique,
            'r_Description'=>'required',
        ];

    }

    public function messages(): array
    {
        $message = [
            'r_Name.required'=>'Tên quyền không được để trống',
            'r_Name.unique'=>'Tên quyền đã tồn tại',
            'r_Description.required'=>'Mô tả không được để trống',
        ];
       
        return $message;
    }
}
