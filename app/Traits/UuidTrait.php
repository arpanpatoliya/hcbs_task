<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

trait UuidTrait
{
    /**
     * Trait Call For UUID set as ID
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->id = Uuid::uuid4()->toString();
        });

    }
}
