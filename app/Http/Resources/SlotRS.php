<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlotRS extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $slot = $this;
       
         return [
            'id' => $slot->id,
            'clinician_id' => $slot->clinician_id, 
            'slot_no' => $slot->slot_no,
            'end_time' => $slot->date .' '. $slot->end_time,
            'start_time' => $slot->date .' '. $slot->start_time,
            'is_booked' => $slot->is_booked,
         ];
    }
}
