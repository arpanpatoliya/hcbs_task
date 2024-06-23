<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WeekendRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $timestamp = strtotime($value);

        // Check if the value is a valid date
        if ($timestamp === false) {
            $fail("The $attribute is not a valid date.");
            return;
        }

        // Get the day of the week (1 for Monday, 7 for Sunday)
        $dayOfWeek = date('N', $timestamp);

        // Check if the day is Saturday (6) or Sunday (7)
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            $fail("The $attribute must be a weekday (Monday to Friday).");
        }
    }
}
