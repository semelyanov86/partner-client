<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class LoanMainSchedule extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'loan_main_schedules';

    protected $dates = [
        'date_plan',
        'date_fact',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'shareholder_id',
        'loan_id',
        'date_plan',
        'date_fact',
        'period',
        'days',
        'main_amt_plan',
        'main_amt_fact',
        'main_amt_debt_plan',
        'main_amt_debt_fact',
        'percent_amt_plan',
        'percent_amt_fact',
        'fee_plan',
        'fee_fact',
        'created_at',
        'updated_at',
        'deleted_at',
        'fee_period',
        'fee_days',
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

    public function getDateFactAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setDateFactAttribute($value)
    {
        $this->attributes['date_fact'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }
}
