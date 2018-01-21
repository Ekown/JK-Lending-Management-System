<?php

namespace App\Http\Controllers;

use App\Events\Remittance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RemittanceController extends Controller
{
	// Auth Middleware restricts access to this controller to only authorized users
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Creates a loan remittance record in the database and fires the Remittance Event
    public function createLoan(Request $request)
    {
        // Creates a loan remittance record in the database
    	$query = DB::table('loan_remittances')->insertGetId(
    		[
    			'loan_id' => $request->loan_id,
    			'date' => $request->remitLoanDate,
    			'amount' => $request->remitLoanAmount
    		]
    	);

        $remittance = DB::table('loan_remittances')
                    ->where('id', $query)
                    ->select('*')
                    ->first();

        // Fires the Remittance Event
        event(new Remittance($request->loan_id, $remittance));

    	return Response::json($query);	
    }

    public function deleteRemittance(Request $request)
    {
        $deleteRemittance = DB::table('loan_remittances')
                            ->where('id', $request->remittance_id)
                            ->delete();

        return Response::json($request->remittance_id);
    }

    public function getCorrespondingDate()
    {
        return Response::json(DB::table('remittance_dates')
                          ->select('remittance_dates.remittance_date')
                          ->whereIn('remittance_dates.id', remittance_date_id())
                          ->get());
    }

    public function getDates()
    {
        return $query = DB::table('remittance_dates')
                ->select('remittance_dates.*')
                ->get();
    }

}
