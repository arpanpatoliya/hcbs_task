<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slot = new Slot();
        $slot->clinician_id = 'f6e25506-dc74-42ab-b271-04706379aaa6';
        $slot->date = Carbon::now()->format('Y-m-d');
        $slot->start_time = Carbon::now()->format('H:m:s');
        $slot->end_time = Carbon::now()->addHours(2)->format('H:m:s');
        $slot->is_booked = 0;
        $slot->save();
    }
}
