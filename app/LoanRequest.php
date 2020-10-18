<?php

namespace App;

use App\Helpers\Utils;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Support\Facades\Log;

class LoanRequest extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'loan_requests';

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
        'sms_code',
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

    public static function saveRequestLoan($inputs, $response, $shareholder_id)
    {
        $loanRequest = new LoanRequest();
        //main fields
        $loanRequest->status = $response['status'];
        $loanRequest->request_no = $response['request_no'];
        $loanRequest->request_date = Carbon::createFromFormat('d.m.Y', $response['date'])->format('Y-m-d');
        $loanRequest->amount = $inputs['amount'];
        $loanRequest->shareholder_id = $shareholder_id;
        $loanRequest->sms_code = $inputs['sms_code'];

        //data fields
        $loanRequest->data = self::formData($inputs);

        $loanRequest->save();
    }

    private static function formData($inputs)
    {
        $data = array();
        //static fields
        array_push($data, array('key'=> 'place', 'title'=>'Населенный пункт', 'type'=>'string',
            'value'=>Place::where("id", $inputs['place'])->whereNull('deleted_at')->first()['name']));

        //dynamic fields
        $fields = RequestField::where("key", '!=', 'amount')
            ->where('type', '!=', 'file')
            ->whereNull('deleted_at')->orderBy('No')->get();

        foreach ($fields as $field)
        {
            $key =  $field['key'];
            $title = $field['title'];
            $type = $field['type'];
            $value = '';

            if ($field['type'] == 'boolean')
            {
                $value = $inputs[$key] == 'on' ? true : false;
            }
            elseif ($field['type']  == 'phone')
            {
                $value = Utils::getFormatedPhone($inputs[$key]);
            }
            elseif ($field['type']  == 'date')
            {
                try {
                    $date = new \DateTimeImmutable($inputs[$key]);
                    $value = $date->format('d.m.Y');
                } catch (\Exception $e) {
                }
            }
            else
            {
                $value = $inputs[$key];
            }

            array_push($data, array('key'=> $key, 'title'=>$title, 'type'=>$type, 'value'=>$value));
        }

        return json_encode($data);
    }

    public function setDataField($key, $value)
    {
        $data = json_decode($this->data, true);
        for ($i = 0; $i < count($data); $i++) {
             if ( $data[$i]['key'] == $key) {
                $data[$i]['value'] = $value;
                break;
            }
        }
       $this->data = json_encode($data);
    }

}
