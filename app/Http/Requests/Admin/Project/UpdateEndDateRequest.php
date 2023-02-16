<?php

namespace App\Http\Requests\Admin\Project;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEndDateRequest extends FormRequest
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
        $startDate = Carbon::parse($this->project->start_date)->subDays(1);

        return [
            'date' => 'required|date|after:' . $startDate,
        ];
    }
}
