<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmailFormRequest extends FormRequest
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
            'subject' => ['required', 'string', 'max:255'],
            'header' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string', 'max:1000'],
            'contact' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'subject' => trans('admin.array_message.error-subject'),
            'header' => trans('admin.array_message.error-header'),
            'content' => trans('admin.array_message.error-content'),
            'contact' => trans('admin.array_message.error-contact'),
        ];
    }

    public function attributes()
    {
        return [
            'subject' => '件名',
            'header' => '挨拶',
            'content' => '内容',
            'contact' => 'コンタクト',
        ];
    }
}
