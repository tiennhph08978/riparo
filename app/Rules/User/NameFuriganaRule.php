<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;

class NameFuriganaRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = str_replace('　', '', $value);
        if (preg_match('/^([ア-ン]|ー)+$/u', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.W002_E008_type_first_name_furigana');
    }
}
