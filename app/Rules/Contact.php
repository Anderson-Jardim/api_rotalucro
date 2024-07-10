<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Contact implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regular expression for phone number (10 to 15 digits)
        $phoneRegex = '/^[0-9]{10,15}$/';

        // Check if the value is a valid email
        return filter_var($value, FILTER_VALIDATE_EMAIL) || preg_match($phoneRegex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid email or phone number.';
    }
}
