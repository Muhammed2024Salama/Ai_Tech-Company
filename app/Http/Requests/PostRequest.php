<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validates the image
            'published_at' => 'nullable|date',
            'status' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
        ];
    }

    // Customize the failed validation response to return JSON
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
