<?php

namespace App\Http\Requests\User\Project;

use App\Rules\City;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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

    public function getValidatorInstance()
    {
        $this->cleanTargetAmount();

        return parent::getValidatorInstance();
    }

    protected function cleanTargetAmount()
    {
        if ($this->request->has('target_amount')) {
            $this->merge([
                'target_amount' => str_replace(',', '', $this->request->get('target_amount')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'image_banner' => 'nullable|file',
            'image_detail' => 'nullable|array',
            'industry_type' => 'required|array',
            'industry_type.*' => 'exists:m_industries,id',
            'city_id' => ['required', 'int', new City()],
            'address' => 'nullable|max:32',
            'm_contact_period_id' => 'required|exists:m_contract_period,id',
            'recruitment_quantity_min' => 'required|int|min:0|max:50',
            'recruitment_quantity_max' => 'required|int|min:0|max:50',
            'recruitment_number' => 'required|int|min:0',
            'work_time' => 'required|max:255',
            'work_content' => 'required|max:255',
            'work_desc' => 'max:1200',
            'special' => 'max:1200',
            'business_development_incorporation' => 'max:1200',
            'employment_incorporation' => 'max:1200',
            'available_date' => 'required|array',
            'check_recruitment' => 'required|integer|min:1',
            'target_amount' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'image_banner.required' => trans('validation.WORK011_E0181'),
            'work_desc.max' => trans('validation.max.string', ['max' => 1000, 'attribute' => trans('validation.attributes.work_desc')]),
            'special.max' => trans('validation.max.string', ['max' => 1000, 'attribute' => trans('validation.attributes.special')]),
            'business_development_incorporation.max' => trans('validation.max.string', ['max' => 1000, 'attribute' => trans('validation.business_development_incorporation.work_desc')]),
            'employment_incorporation.max' => trans('validation.max.string', ['max' => 1000, 'attribute' => trans('validation.attributes.employment_incorporation')]),
        ];
    }
}
