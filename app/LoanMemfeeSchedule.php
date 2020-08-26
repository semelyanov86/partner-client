<?php

namespace App;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanMemfeeSchedule extends Model
{
    use SoftDeletes;

    public $table = 'loan_memfee_schedules';

    protected $dates = [
        'date_plan',
        'created_at',
        'updated_at',
        'deleted_at',
        'date_fact',
    ];

    protected $fillable = [
        'shareholder_id',
        'loan_id',
        'date_plan',
        'mem_fee_plan',
        'mem_fee_fact',
        'created_at',
        'updated_at',
        'deleted_at',
        'date_fact',
        'no',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }

    public function loan()
    {
        return $this->belongsTo(LoanContract::class, 'loan_id');
    }

    public function getDatePlanAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDatePlanAttribute($value)
    {
        $this->attributes['date_plan'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
