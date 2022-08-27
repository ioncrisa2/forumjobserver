<?php

namespace App\Http\Requests;

use App\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
{
    use FailedValidation;

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
            'name'          => 'required|unique:companies,name',
            'description'   => 'required',
            'established'   => 'required|date',
            'company_field' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Nama Perusahaan tidak boleh kosong!',
            'name.unique'               => 'Nama Perusahaan sudah ada!',
            'description.required'      => 'Deskripsi Perusahaan tidak bole kosong!',
            'established.required'      => 'Tahun Berdiri tidak boleh kosong!',
            'established.date'          => 'Tahun Berdiri harus berupa tanggal!',
            'company_field.required'    => 'Bidang Perusahaan tidak boleh kosong!',
        ];
    }

}
