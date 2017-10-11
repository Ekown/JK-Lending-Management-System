<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashAdvanceController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function show()
    {
    	return view('cash_advances.index');
    }
}
