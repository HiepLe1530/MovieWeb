<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EpisodeRequest extends FormRequest
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
        $unique = Rule::unique('episodes', 'e_Episode')->where(function ($query) {
            return $query->where('e_m_id', $this->e_m_id);
        });
        if(session('e_id')){
            $episodeId = session('e_id');
            $unique = Rule::unique('episodes', 'e_Episode')->where(function ($query) {
                return $query->where('e_m_id', $this->e_m_id);
            })->ignore($episodeId);
        }

        $rule = [
            // 'e_Episode'=>'required|'.$unique,
            'e_Episode' => [
                'required',
                $unique
            ],
            'e_MovieVideo'=>'required|mimes:mp4,ogx,oga,ogv,ogg,webm'
        ];
        if(session('e_id')){
            unset($rule['e_MovieVideo']);
        }
        return $rule;
    }

    public function messages(): array
    {
        $message = [
            'e_Episode.required'=>'Tập phim không được để trống',
            'e_Episode.unique'=>'Số thứ tự tập phim đã tồn tại',
            'e_MovieVideo.required'=>'Vui lòng chọn một video',
            'e_MovieVideo.mimes'=>'Video phải có định dạng: mp4,ogx,oga,ogv,ogg,webm'
        ];
       
        return $message;
    }
}
