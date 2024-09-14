<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'favicon' => 'nullable|file|mimes:png,ico|max:1024',
            'app_name' => 'nullable|string',
            'app_status' => 'required|boolean',
            'social_media' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ];
    }
}
