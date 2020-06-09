<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class LoanContract extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'loan_contracts';

    protected $dates = [
        'date_calculate',
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'shareholder_id',
        'date_calculate',
        'agreement',
        'date_start',
        'date_end',
        'amount',
        'percent',
        'mem_fee',
        'actual_debt',
        'full_debt',
        'is_open',
        'created_at',
        'updated_at',
        'deleted_at',
        'mainamt_per_month',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function loanLoanMainSchedules()
    {
        return $this->hasMany(LoanMainSchedule::class, 'loan_id', 'id');

    }

    public function loanLoanMemfeeSchedules()
    {
        return $this->hasMany(LoanMemfeeSchedule::class, 'loan_id', 'id');

    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');

    }

    public function getDateCalculateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setDateCalculateAttribute($value)
    {
        $this->attributes['date_calculate'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }

    public function getDateStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }

    public function getDateEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }
}
