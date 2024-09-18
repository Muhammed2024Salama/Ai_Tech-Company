<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'app_name' => 'required|string|max:255|' . Rule::unique('settings', 'app_name'),
            'app_status' => 'required|boolean',
            'social_media' => 'nullable|url',
            'email' => 'nullable|email|' . Rule::unique('settings', 'email'),
            'phone' => 'nullable|string|' . Rule::unique('settings', 'phone'),
        ];
    }
}
