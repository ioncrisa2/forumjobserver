<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidation;

class ExcelImportRequest extends FormRequest
{
    use FailedValidation;
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
            'file' => 'required|mimes:xls,xlsx',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'File tidak boleh kosong!',
            'file.mimes' => 'File harus berupa file excel!',
        ];
    }
}
