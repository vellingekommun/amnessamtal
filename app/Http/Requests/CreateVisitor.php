<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVisitor extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email',
            'country' => 'required|in:45,46',
            'phone' => 'required|regex:/^[0-9- ]+$/',
            'student' => 'required|max:255',
            'grade' => 'required|exists:grades,id',
        ];
    }
}
