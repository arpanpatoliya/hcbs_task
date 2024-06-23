<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EndTimeAfterStartTime implements ValidationRule
{
    private $startTime;

    public function __construct($startTime)
    {
        $this->startTime = $startTime;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $start = strtotime($this->startTime);
        $end = strtotime($value);

        if ($start === false || $end === false) {
            $fail('The start time or end time is not a valid date.');
            return;
        }

        if ($end <= $start) {
            $fail('The end time must be after the start time.');
        }
    }
}
