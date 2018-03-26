<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ruleID extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            
            'id' => 'nullable|regex: /^[0-9]*$/',
        ];
    }

    // public function messages()
    // {
    //     return [
        
    //     ];
    // }

}