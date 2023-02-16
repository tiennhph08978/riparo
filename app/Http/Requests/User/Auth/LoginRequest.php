<?php

namespace App\Http\Requests\User\Auth;

use App\Rules\CheckVerifyUserRule;
use App\Rules\User\Email;
use App\Rules\User\Password;
use App\Rules\User\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', new Email(), 'max:64', 'exists:users', new CheckVerifyUserRule()],
            'password' => ['required', 'string', new PasswordRule(), 'min:8', 'max:16'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'email.required' => trans('auth.W001_E001_email_required'),
            'email.max' => trans('auth.W001_E002_email_max'),
            'email.email' => trans('auth.W001_E003_email'),
            'email.exists' => trans('auth.W001_E004_email_not_exists'),
            'password.required' => trans('auth.W001_E005_password_required'),
            'password.max' => trans('auth.W002_E001_password_max'),
            'password.min' => trans('auth.W002_E001_password_min'),
        ];
    }
}
