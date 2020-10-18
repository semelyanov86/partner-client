<?php

namespace App;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

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
        'personal_data',
        'read_only',
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

    public static function buildSendRequest($data)
    {
        $request = array();
        foreach (array_keys($data) as $key)
        {
            //static fields
            if ($key == 'place')
            {
                $request[$key] = Place::where("id", $data[$key])->whereNull('deleted_at')->first()['name'];
            }
            elseif ($key == 'sms_code')
            {
                $request[$key] = $data[$key];
            }
            //dynamic fields
            else
            {
                $field = RequestField::where("key", $key)->whereNull('deleted_at')->first();
                if ($field)
                {
                    if ($field['type'] == 'boolean')
                    {
                        $request[$key] = $data[$key] == 'on' ? true : false;
                    }
                    elseif ($field['type']  == 'phone')
                    {
                        $request[$key] = Utils::getFormatedPhone($data[$key]);
                    }
                    elseif ($field['type']  == 'date')
                    {
                        try {
                            $date = new \DateTimeImmutable($data[$key]);
                            $request[$key] = $date->format('d.m.Y');
                        } catch (\Exception $e) {
                        }
                    }
                    else
                    {
                        $request[$key] = $data[$key];
                    }
                }
            }
        }

        return $request;
    }
}
