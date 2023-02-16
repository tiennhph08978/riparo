<?php

namespace App\Http\Requests\Admin;

use App\Rules\User\EmailRule;
use Illuminate\Foundation\Http\FormRequest;

class ReceiveEmailRequest extends FormRequest
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
            'receive_email' => ['required', 'string', 'email', new EmailRule(), 'max:64'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'receive_email.required' => trans('admin.array_message.receive_email_required'),
        ];
    }

    public function attributes()
    {
        return [
            'receive_email' => '通知用メールアドレス',
        ];
    }
}
