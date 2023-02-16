<?php

namespace App\Http\Requests\User\Project;

use Illuminate\Foundation\Http\FormRequest;

class RecruitmentRequest extends FormRequest
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
        $requestType = array_keys(config('project.request_type'));
        $contactType = array_keys(config('project.contact_type'));

        return [
            'request_type' => 'required|int|in:' . implode(',', $requestType),
            'contact_type' => 'required|int|in:' . implode(',', $contactType),
        ];
    }
}
