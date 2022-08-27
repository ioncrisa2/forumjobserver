<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => 'Title tidak boleh kosong!!',
            'title.min' => 'Title tidak boleh kurang dari :min kata!!',
            'body.required' => 'Content Body tidak boleh kosong!!',
            'category.required' => 'Content Category tidak boleh kosong!!'
        ];
    }

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'body' => 'required',
            'category' => 'required'
        ];
    }
}
