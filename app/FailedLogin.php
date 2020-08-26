<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FailedLogin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ip_address',
        'phone',
        'created_at',
        'updated_at',
        'deleted_at',
        'sms',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
