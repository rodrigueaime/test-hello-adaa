<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users,email|',
            'password' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'civilite' => 'required',
            'confirm_password' => 'same:password|required', 
            // 'username' => 'required'
        ];
    }

}
