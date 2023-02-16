<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
        $statuses = array_keys(config('master_data.m_projects'));

        return [
            'search' => 'nullable|string|max:' . config('validate.max_string_length'),
            'status' => 'nullable|int|in:' . implode(',', array_merge($statuses, ['6'])),
        ];
    }
}
