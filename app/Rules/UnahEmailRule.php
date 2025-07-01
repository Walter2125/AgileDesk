<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UnahEmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the email ends with @unah.hn or @unah.edu.hn (case insensitive)
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@(unah\.hn|unah\.edu\.hn)$/i', $value)) {
            $fail('Sólo se permiten correos electrónicos con dominio @unah.hn o @unah.edu.hn.');
        }
    }
}
