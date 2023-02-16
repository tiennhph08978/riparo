<?php

namespace App\Http\Requests\Admin\Project;

use App\Rules\CheckPdfFile;
use Illuminate\Foundation\Http\FormRequest;

class UploadPdfRequest extends FormRequest
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
            'pdf' => ['required', 'file', new CheckPdfFile(), 'max:102400'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'pdf.mimes' => trans('project.validation.mimes'),
            'pdf.max' => trans('project.validation.pdf_100MB'),
        ];
    }
}
