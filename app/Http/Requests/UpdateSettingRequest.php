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
            'app_name' => 'sometimes|string|max:255',
            'app_status' => 'sometimes|boolean',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'favicon' => 'nullable|file|mimes:ico,png',
            'social_media' => 'nullable|array',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ];
    }
}
