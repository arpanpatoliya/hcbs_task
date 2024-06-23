<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
      'slot_id',
      'clinician_id',
      'appointment_no',
      'name',
      'email',
      'phone_number',
      'signature',
      'appointment_status',
      'fcm_token'
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
            if (empty($appointment->appointment_no)) {
               try {
                  $appointment->appointment_no = self::generateAppointmentID();
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
        $lastAppointmentNo = self::orderBy('appointment_no', 'desc')->first();
        $newAppointmentNo = $lastAppointmentNo ? ((int) str_replace('APPT', '', $lastAppointmentNo->invoice_no)) + 1 : 1;

        $AppointmentNo = str_pad($newAppointmentNo, 6, '0', STR_PAD_LEFT);
        return 'APPT' . $AppointmentNo;
    }

    function slot() : HasOne {
         return $this->hasOne(Slot::class,'id','slot_id');
    }

    function clinician(): HasOne  {
      return $this->hasOne(Clinician::class,'id','clinician_id');
 }
}
