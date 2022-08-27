<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'established' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Perusahaan tidak boleh kosong!',
            'description.required' => 'Deskripsi Perusahaan tidak bole kosong!',
            'established.required' => 'Tahun Berdiri tidak boleh kosong!'
        ];
    }
}
