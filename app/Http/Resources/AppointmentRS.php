<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {  
        $appointment = $this;
        return [
            'id' => $appointment->id,
            'clinician_id' => $appointment->clinician_id, 
            'appt_no' => $appointment->appointment_no,
            'end_time' => $appointment->date .' '. $appointment->end_time,
            'start_time' => $appointment->date .' '. $appointment->start_time,
            'is_booked' => $appointment->is_booked,
            'appointment_status' => $appointment->appointment_status
         ];
    }
}
