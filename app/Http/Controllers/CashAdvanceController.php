<?php

namespace App\Http\Controllers;

use App\Events\AddCashAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CashAdvanceController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    // Create a cash advance record with cash advance amount record
    public function create(Request $request)
    {

    	// Create a cash advance amount record
    	$createCashAdvanceAmount = DB::table('cash_advance_amount')
    								->insertGetId(
    								[
                                    	'date' => $request->addCashAdvanceDate,
                                    	'amount' => $request->addCashAdvanceAmount
                                    ]
                                );

    	// Create a cash advance record
    	$createCashAdvance = DB::table('cash_advances')
    							->insertGetId(
    								[
                                    	'loan_id' => $request->loan_id,
                                    	'cash_advance_amount_id' => $createCashAdvanceAmount
                                    ]
                                );

  		// Fire the Add Cash Advance Event
        event(new AddCashAdvance($createCashAdvance));

    	return Response::json($createCashAdvance);
    }

    public function show()
    {
    	return view('cash_advances.index');
    }
}
