<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clinician;
use App\Enums\GenderEnum;
use Illuminate\Support\Facades\Hash;

class DefaultClinician extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinician = new Clinician();
        $clinician->name = 'Arpan';
        $clinician->last_name = 'Patoliya';
        $clinician->email = 'arpanpatoliya@gmail.com';
        $clinician->password = Hash::make('123456');
        $clinician->occupation = 'therapist';
        $clinician->gender = GenderEnum::MALE;
        $clinician->status = 1;
        $clinician->save();
    }
}
