<?php

namespace App\Http\Controllers;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Helpers\Utils;
use App\LoanRequest;
use App\Place;
use App\RequestField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShareholderRequestsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        return view('shareholder.requests');
    }

    public function item($id)
    {
        $loanRequest = LoanRequest::where('shareholder_id', auth()->user()->id)
            ->whereNull('deleted_at')->where('id', $id);
        if ($loanRequest->count() > 0)
             return view('shareholder.requests-item')->with('loanRequest', $loanRequest->first());
        else
            abort(404);
    }

    public function search (Request $request)
    {
        $loanRequests = LoanRequest::where('shareholder_id', auth()->user()->id)
        ->whereNull('deleted_at')->when(request('dateFromFilter'), function($query) {
            return $query->where('request_date','>=', request('dateFromFilter'));
        })->when(request('dateToFilter'), function($query) {
            return $query->where('request_date','<=', request('dateToFilter'));
        })->orderBy('request_date', 'desc');

        $recordsTotal =  $loanRequests->count();

        $data = array('data' => $loanRequests->skip($request->query('start'))->take($request->query('length'))->get(),
            'recordsTotal' => $recordsTotal,
            "recordsFiltered" => $recordsTotal
            );

        return response()->json($data);
    }

    public function new()
    {
        if (auth()->user()->allow_request == false)
            abort(404);

        $fields = RequestField::whereNull('deleted_at')->orderBy('no', 'asc')->get();
        $places = Place::whereNull('deleted_at')->orderBy('name')->get();
        return view('shareholder.requests-create')
            ->with('fields', $fields)
            ->with('places', $places);
    }

    protected function validator(array $data)
    {
        $messages = array();
        $messages += ['required' => 'Поле обязательно к заполнению'];

        $rules = array(
            'place' => ['required'],
            'personal_data_accept' => ['required']
        );

        $requestFields = RequestField::whereNull('deleted_at')->get();

        foreach ($requestFields as $requestField)
        {
            $key = $requestField->key;
            if ($requestField)
            {
                $rules += [$key => []];

                if ($requestField['type'] == 'file')
                {
                    $messages += [$key.'.max' => 'Максимальный размер файла 3 Мб'];
                    $rules[$key] += ['max:3072'];
                }

                if ($requestField['required'] == true)
                {
                    $rules[$key] += ['required'];
                }
            }
        }

        return Validator::make($data, $rules, $messages);
    }

    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        $response = ExtApiUtils::sendLoanRequest(RequestField::buildSendRequest($request->input()),  $request);

        if ($response)
        {
            LoanRequest::saveRequestLoan($request->input(), $response, auth()->user()->id);
        }
        else
            return redirect()->back()
                ->withErrors(['error_msg' =>
                    'Не удалось отправить заявку! Попробуйте позднее или свяжитесь с тех. поддержкой!'])
                ->withInput($request->all());

        return redirect()->route('client.thanks')->withMessage('Ваша заявка успешно отправлена! № заявки '.$response['request_no']." от ".$response['date']);
    }

    public function update($id)
    {
        $loanRequest = LoanRequest::where('shareholder_id', auth()->user()->id)->where('id', $id)->whereNull('deleted_at');
        if ($loanRequest->count() > 0)
        {
            if (ExtApiUtils::updateLoanRequest($id))
                return $this->item($id);
            else
                return redirect()->back()->withErrors(['error_msg' =>
                    'Не удалось обновить данные']);
        }
        else
            abort(404);
    }

    public function getShareholderInfo()
    {
        return response()->json(ExtApiUtils::getShareholderForLoan(auth()->user()->phone));
    }

    public function sendSMS()
    {
        $shareholder = auth()->user();

        if(!FailedLoginUtils::canResendSMS($shareholder->phone))
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'СМС не может быть отправлена чаще чем 1 раз в '.env('SMS_RESEND_DELAY_SECONDS', 60)." секунд.  "
                ]);

        if (FailedLoginUtils::getRemainSMSCount($shareholder->phone) <= 0)
        {
            return response()->json(
                [
                    'success' => false,
                    'msg' => "Слишком много неправильных попыток. Для вас заблокирована возможность отправки СМС в течении ".env("BAN_TIME_MINUTES",60)." мин."
                ]);
        }

        $shareholder->resetTwoFactorCode();
        $shareholder->generateTwoFactorCode();

        if (!SmsUtils::sendSMSCode($shareholder->phone, $shareholder->code, ''))
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Ошибка при отправке СМС. Попробуйте позднее'
                ]);

        return response()->json(['success' => true, 'msg' => 'СМС отправлена']);
    }

    public function verifySMS(Request $request)
    {
        $code = request('code');
        $shareholder = auth()->user();

        if($shareholder->code)
        {
            if(!$shareholder->code_expires_at || $shareholder->code_expires_at->lessThan(now()))
            {
                $shareholder->resetTwoFactorCode();
                return response()->json(['success' => false, 'msg' => 'Срок действия СМС кода истек. Пожалуйста, попробуйте еще раз.']);
            }

            if($shareholder->code != $code)
            {
                return response()->json(['success' => false, 'msg' => 'Введен неверный код']);
            }
        }

        return response()->json(['success' => true, 'msg' => 'Согласие на обработку персональных данных подтверждено']);
    }

}
