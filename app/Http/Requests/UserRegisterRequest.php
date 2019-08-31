<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
          'email' => 'email|required|unique:users,email',
          'first_name' => 'required',
          'last_name' => 'required',
          'password' => 'required|min:6'
        ];
    }
}
