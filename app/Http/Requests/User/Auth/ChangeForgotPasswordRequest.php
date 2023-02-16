<?php

namespace App\Http\Requests\User\Auth;

use App\Rules\PasswordConfirm;
use App\Rules\User\Password;
use App\Rules\User\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeForgotPasswordRequest extends FormRequest
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
            'password' => ['required', new PasswordRule(), 'min:8', 'max:16'],
            'password_confirmation' => ['required', new PasswordRule(), 'same:password'],
            'token' => 'required|string|max:64',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('validation.W001_E005_required_password'),
            'password.min' => trans('validation.W014_E005_min_password'),
            'password.max' => trans('validation.W014_E004_max_password'),

            'password_confirmation.required' => trans('validation.w002_E014_required_confirm'),
            'password_confirmation.same' => trans('validation.w001_E015_confirm_same'),

            'token.required' => trans('validation.W001_E005_required_password'),
            'token.string' => trans('validation.W002_E019_type_post_code'),
            'token.max' => trans('validation.W001_E002_max_email'),
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'パスワード',
            'password_confirmation' => '確認パスワード',
        ];
    }
}
