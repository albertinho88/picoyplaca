<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PlateNumber implements Rule
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
        if (strlen($value) == 6 || strlen($value) == 7) {
            $letters = substr($value, 0, 3);
            $numbers = substr($value, 3);
            $last_digit = substr($value, -1);

            return ctype_alpha($letters) && ctype_digit($numbers);

        } else {
            return false;
        }
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute must be a valid Plate Number';
    }
}
