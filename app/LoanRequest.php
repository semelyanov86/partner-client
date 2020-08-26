<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanRequest extends Model
{
    use SoftDeletes, Auditable;

    protected $dates = [
        'request_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'shareholder_id',
        'request_no',
        'amount',
        'status',
        'request_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'data',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }

    public function getRequestDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setRequestDateAttribute($value)
    {
        $this->attributes['request_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
