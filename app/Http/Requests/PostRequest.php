<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       

        // if(request()->isMethod('put'))
        //     $passwordValidation = 'nullable|string|max:255';

        return [
            'content' => 'required|string|max:255',
            'title' => 'required',
        ];
    }
}
