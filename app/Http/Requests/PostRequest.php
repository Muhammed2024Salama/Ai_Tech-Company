<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
            'status' => 'required|integer',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
        ];
    }

    /**
     * @return void
     * Prepare the data for validation
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'published_at' => $this->input('published_at') ?? now(),
        ]);
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * Customize the failed validation response to return JSON
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
