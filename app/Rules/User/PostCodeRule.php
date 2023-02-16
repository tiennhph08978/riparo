<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;

class PostCodeRule implements Rule
{
    protected $city;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($city)
    {
        $this->city = $city;
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
        if (preg_match('/^[0-9]+$/', $value) && $this->city) {
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
        return trans('validation.W002_E022_not_exist');
    }
}
