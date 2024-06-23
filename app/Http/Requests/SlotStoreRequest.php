<?php

namespace App\Http\Requests;

use App\Rules\{
    ChaeckOverlappingTimeSlotRule,
    EndTimeAfterStartTime,
    WeekendRule
};
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SlotStoreRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $slotDate = $this->input('slot_date');
        $startTime = $this->input('start_time');
        $endTime = $this->input('end_time');
        $clinician = Auth::guard('clinician')->user()->id;
        return [
            'slot_date' => [
                'required',
                'date',
                'after_or_equal:today',
                new WeekendRule
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                new EndTimeAfterStartTime($this->input('start_time')),
                new ChaeckOverlappingTimeSlotRule($slotDate, $startTime, $endTime, $clinician),
            ],
        ];
    }
}
