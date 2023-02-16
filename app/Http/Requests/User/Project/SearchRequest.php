<?php

namespace App\Http\Requests\User\Project;

use App\Models\Category;
use App\Rules\City;
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
        $filterTypes = array_keys(config('project.filter'));

        return [
            'search' => 'nullable|string|max:' . config('validate.max_string_length'),
            'category_id' => 'nullable|int|exists:categories,id',
            'city_id' => ['nullable', 'int', new City()],
            'filter_type' => 'nullable|int|in:' . implode(',', $filterTypes),
        ];
    }
}
