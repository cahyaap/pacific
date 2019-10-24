<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $page = "stock";
        return view('stock.list', compact(['page']));
    }
}
