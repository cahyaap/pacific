<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandList;
use App\Models\Payment;
use App;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $page = "payment";
        return view('payment.list', compact(['page']));
    }

    public function getPaymentTable()
    {
        $payments = Payment::with(['demand.demand_list.demand_item', 'demand.creator'])->orderBy('id', 'desc')->get();
        $paymentTotals = DemandList::groupBy('demand_id')->selectRaw('SUM(price*quantity) as total, demand_id')->get();
        $totals = [];
        foreach ($paymentTotals as $paymentTotal) {
            $totals[$paymentTotal->demand_id] = $paymentTotal->total;
        }
        return view('payment.table', compact(['payments', 'totals']));
    }

    public function getPaymentData(Request $request) {
        $payment = Payment::with(['demand.demand_list.demand_item', 'demand.creator'])->where('id', $request->input('id'))->get();
        return response()->json([
            "message" => "success",
            "data" => $payment
        ]);
    }

    public function approveOrReject(Request $request) {
        $approveOrReject = $request->input('approveOrReject');
        $payment = Payment::find($request->input('id'));
        $status = $payment->status;
        if ($approveOrReject === "approve"){
            $payment->status = $status + 1;
        } else {
            $payment->status = 9;
        }
        $payment->updated_at = now();
        $payment->save();
        return response()->json([
            "message" => "success",
            "data" => $payment
        ]);
    }

    public function printPayment() {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('payment.print');
        return $pdf->stream();
    }
}
