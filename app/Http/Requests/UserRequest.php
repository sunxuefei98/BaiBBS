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
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' =>'The avatar must be a picture in jpeg, bmp, png, gif format',
            'avatar.dimensions' => 'The sharpness of the picture is not enough, both width and height need to be 208px or more',
            'name.unique' => 'This username is already taken. Please choose another name.',
            'name.regex' => 'Usernames can only comprise letters (a-z), numbers (0-9), dash and underscore.',
            'name.between' => 'Must be between 3-25 characters long.',
            'name.required' => 'Username cannot be empty',
        ];
    }
}
