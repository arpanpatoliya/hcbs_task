<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Clinician extends Authenticatable
{
    use HasFactory,SoftDeletes,UuidTrait;

    /**
     * @var string
     */
    protected $table = 'clinicians';

    protected $fillable =[
        'id',
        'name',
        'email',
        'password',
        'profile',
        'gender',
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

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }
}
