<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Appointment extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    /**
     * @var string
     */
    protected $table = 'appointments';

    protected $fillable =[
        'id',
        'clinician_id',
        'appointment_id',
        'start_time',
        'end_time',
        'is_booked',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

        /**
     *
     * Increment id to false
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     *
     * ID In String
     *
     * @var string
     */
    public $keyType = 'string';

    protected static function booted()
    {
         static::creating(function ($appointment) {
            if (empty($appointment->appointment_id)) {
               try {
                  $appointment->appointment_id = self::generateAppointmentID();
               } catch (\Exception $e) {
                  Log::error('Error generating unique invoice number: ' . $e->getMessage());
               }
            }
         });
    }

    /**
     * Generate a unique appointment ID.
     *
     * @return string
     */
    public static function generateAppointmentID()
    {
        $lastAppointmentID = self::orderBy('appointment_id', 'desc')->first();
        $newAppointmentID = $lastAppointmentID ? ((int) str_replace('APPT', '', $lastAppointmentID->invoice_no)) + 1 : 1;

        $AppointmentID = str_pad($newAppointmentID, 6, '0', STR_PAD_LEFT);
        return 'APPT' . $AppointmentID;
    }
}
