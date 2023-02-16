<?php

namespace App\Http\Requests\User;

use App\Rules\User\EmailRule;
use App\Rules\User\NameFuriganaRule;
use App\Rules\User\PasswordRule;
use App\Rules\User\PhoneRule;
use App\Rules\User\PostCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $this->cleanPostCode();

        return parent::getValidatorInstance();
    }

    protected function cleanPostCode()
    {
        if ($this->request->has('post_code')) {
            $this->merge([
                'post_code' => str_replace(['-', '_', ''], '', $this->request->get('post_code')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:16',
            'first_name_furigana' => ['required', 'string', new NameFuriganaRule(), 'max:24'],
            'last_name' => 'required|string|max:16',
            'last_name_furigana' => ['required', 'string', new NameFuriganaRule(), 'max:24'],
            'email' => ['required', 'string', new EmailRule(), 'max:64', 'email', 'unique:users,email'],
            'password' => ['required', 'string', new PasswordRule(), 'min:8', 'max:16'],
            'password_confirmation' => ['required', new PasswordRule(), 'same:password'],
            'phone_number' => ['required', 'numeric', new PhoneRule(), 'digits_between:10,11'],
            'post_code' => ['required', 'numeric', 'digits:7', new PostCodeRule($this->city)],
            'address' => 'required|string|max:32',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'first_name.required' => trans('validation.W002_E002_required_first_name'),
            'first_name.max' => trans('validation.W002_E003_max_16_first_name'),
            'first_name_furigana.required' => trans('validation.W002_E006_required_first_name_furigana'),
            'first_name_furigana.string' => trans('validation.W002_E008_type_first_name_furigana'),
            'first_name_furigana.max' => trans('validation.W002_E007_max_first_name_furigana'),
            'last_name.required' => trans('validation.W002_E004_required_last_name'),
            'last_name.max' => trans('validation.W002_E005_max_last_name'),
            'last_name_furigana.required' => trans('validation.W002_E009_required_last_name_furigana'),
            'last_name_furigana.string' => trans('validation.W002_E011_type_last_name_furigana'),
            'last_name_furigana.max' => trans('validation.W002_E010_max_last_name_furigana'),
            'email.required' => trans('validation.W001_E001_required_email'),
            'email.string' => trans('validation.W001_E003_type_email'),
            'email.max' => trans('validation.W001_E002_max_email'),
            'email.unique' => trans('validation.W002_E023_unique_mail'),
            'email.email' => trans('validation.W001_E003_type_email'),
            'password.required' => trans('validation.W001_E005_required_password'),
            'password.min' => trans('validation.W002_E012_min_password'),
            'password.max' => trans('validation.W014_E004_max_password'),
            'phone_number.required' => trans('validation.W002_E016_required_phone_number'),
            'phone_number.numeric' => trans('validation.W002_E017_numeric_phone_number'),
            'phone_number.digits_between' => trans('validation.W002_E017_numeric_phone_number'),
            'post_code.required' => trans('validation.W002_E018_required_post_code'),
            'post_code.digits' => trans('validation.W002_E019_type_post_code'),
            'address.required' => trans('validation.W002_E020_required_address'),
            'password_confirmation.required' => trans('validation.w002_E014_required_confirm'),
            'password_confirmation.same' => trans('validation.w001_E015_confirm_same'),
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
