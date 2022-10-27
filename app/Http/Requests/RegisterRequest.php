<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email telah terdaftar!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password tidak boleh kurang dari :min karakter!',
            'confirm_password.required' => 'Password tidak boleh kosong!',
            'confirm_password.same' => 'Password tidak sama !',
        ];
    }
}
