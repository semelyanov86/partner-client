<?php

namespace App\Http\Controllers;

use App\Helpers\ExtApiUtils;
use App\LoanContract;
use App\LoanMainSchedule;
use App\LoanMemfeeSchedule;
use Illuminate\Http\Request;


class ShareholderLoanController extends Controller
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
        //ExtApiUtils::updateAllContractLoan(auth()->user()->id, true);
        return view('shareholder.loans');
    }

    public function item($id)
    {
        $loanContract = LoanContract::where('shareholder_id', auth()->user()->id)->where('id', $id)->whereNull('deleted_at');
        if ($loanContract->count() > 0)
        {
            $mainSchedule = LoanMainSchedule::where('loan_id', $id)
                ->whereNull('deleted_at')
                ->orderByRaw('no', 'ASC');


            $memfeeSchedule = LoanMemfeeSchedule::where('loan_id', $id)
                ->whereNull('deleted_at')
                ->orderByRaw('no', 'ASC');

            $qrCodeText = ExtApiUtils::generateQrCodeText("Договор займа №".$loanContract->first()->agreement, auth()->user()->fio);

            return view('shareholder.loans-item')
                ->with('loanContract', $loanContract->first())
                ->with('mainSchedule', $mainSchedule->get())
                ->with('memfeeSchedule', $memfeeSchedule->get())
                ->with('qrCodeText', $qrCodeText)
                ->with('qrSbpPurpose', 'Оплата по договору займа №'.$loanContract->first()->agreement);
        }
        else
            abort(404);
    }

    public function update($id)
    {
        $loanContract = LoanContract::where('shareholder_id', auth()->user()->id)->where('id', $id)->whereNull('deleted_at');
        if ($loanContract->count() > 0)
        {
            if (ExtApiUtils::updateContractLoan($id))
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
        $loanContracts = LoanContract::where('shareholder_id', auth()->user()->id)->whereNull('deleted_at')
            ->when(request('dateFromFilter'), function($query) {
            return $query->where('date_start','>=', request('dateFromFilter'));
        })->when(request('dateToFilter'), function($query) {
            return $query->where('date_start','<=', request('dateToFilter'));
        })->when(request('isOpen') == 'true', function($query) {
            return $query->where('full_debt', '>', 0);
        })->orderBy('date_start', 'desc');

        $recordsTotal = $loanContracts->count();

        $start = 0;
        if ($request->query('start'))
            $start = $request->query('start');

        $length = $recordsTotal;
        if ($request->query('length'))
            $length =  $request->query('length');

        $data = array('data' => $loanContracts
            ->skip($start)
            ->take($length)
            ->get(),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
        );

        return response()->json($data);
    }
}
