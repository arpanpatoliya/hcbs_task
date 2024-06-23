<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Slot;

class ChaeckOverlappingTimeSlotRule implements ValidationRule
{
    private $slotDate;
    private $startTime;
    private $endTime;
    private $clinician;
    private $slot_id;

    public function __construct($slotDate, $startTime, $endTime, $clinician, $slot_id = null)
    {
        $this->slotDate = $slotDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->clinician = $clinician;
        $this->slot_id = $slot_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $overlapping = Slot::where('clinician_id', $this->clinician);

        $overlapping->where('date', $this->slotDate)
        ->where(function ($query) {
            $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                  ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                  ->orWhere(function ($query) {
                      $query->where('start_time', '<', $this->startTime)
                            ->where('end_time', '>', $this->endTime);
                  });
        });
        if ($this->slot_id != null) {
            $overlapping->where('id','!=', $this->slot_id);
        }
        $overlapping = $overlapping->exists();

    if ($overlapping) {
        $fail('The given time slot overlaps with an existing time slot.');
    }
    }
}
