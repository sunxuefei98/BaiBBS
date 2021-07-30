<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
                // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'       => 'required|min:2',
                    'body'        => 'required|min:3',
                    'category_id' => 'required|numeric',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }

    public function messages()
    {
        return [
            'title.min' => 'The title must be at least two characters',
            'body.min' => 'The content must be at least three characters',
        ];
    }
}
