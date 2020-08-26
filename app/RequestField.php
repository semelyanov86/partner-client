<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestField extends Model
{
    use SoftDeletes;

    public $table = 'request_fields';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'no',
        'key',
        'title',
        'placeholder',
        'required',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_SELECT = [
        'string'   => 'string',
        'number'   => 'number',
        'textarea' => 'textarea',
        'phone'    => 'phone',
        'mail'     => 'mail',
        'boolean'  => 'boolean',
        'date'     => 'date',
        'file'     => 'file',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
