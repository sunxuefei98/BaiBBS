<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'This username is already taken. Please choose another name.',
            'name.regex' => 'Usernames can only comprise letters (a-z), numbers (0-9), dash and underscore.',
            'name.between' => 'Must be between 3-25 characters long.',
            'name.required' => 'Username cannot be empty',
        ];
    }
}
