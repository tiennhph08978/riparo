<?php

namespace App\Http\Requests\User;

use App\Rules\User\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', new EmailRule(), 'max:64', 'email'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('validation.W001_E001_required_email'),
            'email.string' => trans('validation.W001_E003_type_email'),
            'email.max' => trans('validation.W001_E002_max_email'),
            'email.email' => trans('validation.W001_E003_type_email'),
        ];
    }
}
