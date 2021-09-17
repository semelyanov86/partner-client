<?php

namespace App\Http\Controllers;

use App\DepositContract;
use App\DepositSchedule;
use App\Helpers\ExtApiUtils;
use Illuminate\Http\Request;


class ShareholderDepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('shareholder.deposits');
    }

    public function item($id)
    {
        $depositContract = DepositContract::where('shareholder_id', auth()->user()->id)->where('id', $id)->whereNull('deleted_at');
        if ($depositContract->count() > 0)
        {
            $mainSchedule = DepositSchedule::where('deposit_id', $id)
                ->whereNull('deleted_at')
                ->orderByRaw('no', 'ASC');

            $qrCodeText = ExtApiUtils::generateQrCodeText("Договор сбережений №".$depositContract->first()->agreement, auth()->user()->fio);

            return view('shareholder.deposits-item')
                ->with('depositContract', $depositContract->first())
                ->with('mainSchedule', $mainSchedule->get())
                ->with('qrCodeText', $qrCodeText)
                ->with('qrSbpPurpose', 'Оплата по договору сбережений №'.$depositContract->first()->agreement);
        }
        else
            abort(404);
    }

    public function update($id)
    {
        $depositContract = DepositContract::where('shareholder_id', auth()->user()->id)->where('id', $id)->whereNull('deleted_at');
        if ($depositContract->count() > 0)
        {
            if (ExtApiUtils::updateContractDeposit($id))
                return $this->item($id);
            else
                return redirect()->back()->withErrors(['error_msg' =>
                    'Не удалось обновить данные']);
        }
        else
            abort(404);
    }

    public function search (Request $request)
    {
        $depositContracts = DepositContract::where('shareholder_id', auth()->user()->id)->whereNull('deleted_at')
            ->when(request('dateFromFilter'), function($query) {
            return $query->where('date_start','>=', request('dateFromFilter'));
        })->when(request('dateToFilter'), function($query) {
            return $query->where('date_start','<=', request('dateToFilter'));
        })->when(request('isOpen') == 'true', function($query) {
            return $query->where('is_open', 1);
        })->orderBy('date_start', 'desc');

        $recordsTotal = $depositContracts->count();

        $start = 0;
        if ($request->query('start'))
            $start = $request->query('start');

        $length = $recordsTotal;
        if ($request->query('length'))
            $length =  $request->query('length');

        $data = array('data' => $depositContracts
            ->skip($start)
            ->take($length)
            ->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
        );

        return response()->json($data);
    }
}
