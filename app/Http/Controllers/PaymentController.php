<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
