<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Shareholder extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'shareholders';

    protected $dates = [
        'sms_sended_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'phone',
        'password',
        'code',
        'sms_sended_at',
        'doc',
        'fio',
        'allow_request',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function shareholderLoanRequests()
    {
        return $this->hasMany(LoanRequest::class, 'shareholder_id', 'id');

    }

    public function shareholderDepositContracts()
    {
        return $this->hasMany(DepositContract::class, 'shareholder_id', 'id');

    }

    public function shareholderLoanContracts()
    {
        return $this->hasMany(LoanContract::class, 'shareholder_id', 'id');

    }

    public function getSmsSendedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;

    }

    public function setSmsSendedAtAttribute($value)
    {
        $this->attributes['sms_sended_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;

    }
}
