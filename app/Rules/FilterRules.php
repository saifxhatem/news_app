<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FilterRules implements Rule
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
        //
        if ($value == 'all' | $value == 'eg' | $value == 'ae' | $value == 'business' | $value == 'sports')
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid filter';
    }
}
