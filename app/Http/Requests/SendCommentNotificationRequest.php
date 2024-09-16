<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendCommentNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer|exists:posts,id',
            'comment_id' => 'required|integer|exists:comments,id',
            'email' => 'required|email',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'post_id.required' => 'The post ID is required.',
            'post_id.exists' => 'The selected post does not exist.',
            'comment_id.required' => 'The comment ID is required.',
            'comment_id.exists' => 'The selected comment does not exist.',
            'email.required' => 'An email address is required.',
            'email.email' => 'The email address must be valid.',
        ];
    }
}
