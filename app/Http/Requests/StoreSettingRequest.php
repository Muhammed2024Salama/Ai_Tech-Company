<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:2048',
            'app_name' => 'required|string|max:255',
            'app_status' => 'required|boolean',
            'social_media' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ];
    }
}
