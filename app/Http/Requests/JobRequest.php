<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'job_name' => 'required',
            'job_description' => 'required',
            'poster' => 'mimes:png,jpg|max:2048',
            'job_type' => 'required',
        ];
    }

    public function messages(){
        return [
            'job_name.required' => 'Nama Pekerjaan tidak boleh kosong',
            'job_description.required' => 'Deskripsi Pekerjaan tidak boleh kosong',
            'poster.required' => 'Poster Pekerjaan tidak boleh kosong',
            'poster.mimes' => 'Poster Pekerjaan harus berupa file gambar',
            'poster.max' => 'Poster Pekerjaan tidak boleh lebih dari 2MB',
            'job_type.required' => 'Tipe Pekerjaan tidak boleh kosong',
        ];
    }
}
