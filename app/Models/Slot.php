<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Slot extends Model
{
    use HasFactory, SoftDeletes, UuidTrait;

    /**
     * @var string
     */
    protected $table = 'slots';

    protected $fillable =[
        'id',
        'clinician_id',
        'slot_no',
        'date',
        'start_time',
        'end_time',
        'is_booked',
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
         static::creating(function ($slot) {
            if (empty($slot->slot_no)) {
               try {
                  $slot->slot_no = self::generateSlotNo();
               } catch (\Exception $e) {
                  Log::error('Error while slot no: ' . $e->getMessage());
               }
            }
         });
    }

    /**
     * Generate a unique appointment ID.
     *
     * @return int
     */
    public static function generateSlotNo()
    {
        $lastSlotNo = self::withTrashed()->orderBy('slot_no', 'desc')->first();
        $newSlotNo = $lastSlotNo ? $lastSlotNo->slot_no + 1 : 1;        
        return $newSlotNo;
    }
}
