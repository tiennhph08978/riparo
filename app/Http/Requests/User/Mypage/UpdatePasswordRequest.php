<?php

namespace App\Http\Requests\User\Mypage;

use App\Rules\PasswordConfirm;
use App\Rules\User\CheckCurrentPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', new PasswordConfirm(), new CheckCurrentPasswordRule()],
            'new_password' => ['required', new PasswordConfirm(), 'min:8', 'max:16'],
            'confirm_password' => ['required', new PasswordConfirm(), 'same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => trans('validation.WORK014_E001_required_cur_password'),

            'new_password.required' => trans('validation.WORK014_E003_required_new_password'),
            'new_password.min' => trans('validation.WORK014_E004_new_min_password'),
            'new_password.max' => trans('validation.WORK014_E005_new_max_password'),

            'confirm_password.required' => trans('validation.WORK014_E010_new_required_confirm'),
            'confirm_password.same' => trans('validation.W014_E006_confirm_password'),
        ];
    }

    public function attributes()
    {
        return [
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
            'confirm_password' => '新しいパスワード（再入力）',
        ];
    }
}
