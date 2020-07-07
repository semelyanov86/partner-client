<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class DepositSchedule extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'deposit_schedules';

    protected $dates = [
        'date_plan',
        'date_fact',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'deposit_id',
        'shareholder_id',
        'date_plan',
        'date_fact',
        'period',
        'days',
        'main_amt_debt',
        'main_amt_fact',
        'ndfl_amt',
        'percent_available',
        'created_at',
        'updated_at',
        'deleted_at',
        'no',
        'percent_amt_plan',
        'percent_amt_fact',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function deposit()
    {
        return $this->belongsTo(DepositContract::class, 'deposit_id');

    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');

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
