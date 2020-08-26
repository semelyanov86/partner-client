<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Shareholder extends Authenticatable
{
    use SoftDeletes, Auditable;

    public $table = 'shareholders';
    protected $guarded = 'shareholder';

    protected $dates = [
        'sms_sended_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'code_expires_at',
    ];

    protected $fillable = [
        'phone',
        'sms_sended_at',
        'doc',
        'fio',
        'allow_request',
        'created_at',
        'updated_at',
        'deleted_at',
        'password',
        'code',
        'code_expires_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'code',
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
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format').' '.config('panel.time_format')) : null;
    }

    public function setSmsSendedAtAttribute($value)
    {
        $this->attributes['sms_sended_at'] = $value ? Carbon::createFromFormat(config('panel.date_format').' '.config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->code = null;
        $this->code_expires_at = null;
        $this->sms_sended_at = null;
        $this->save();
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->code = rand(100000, 999999);
        //tmp
        $this->code = 123123;
        $this->code_expires_at = now()->addSeconds(config('settings.sms_expires_seconds'));
        $this->sms_sended_at = now();
        $this->save();
    }
}
