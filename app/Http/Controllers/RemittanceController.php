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

    public function createLoan(Request $request)
    {
    	$query = DB::table('loan_remittances')->insert([
    		[
    			'loan_id' => $request->loan_id,
    			'date' => $request->remitLoanDate,
    			'amount' => $request->remitLoanAmount
    		]
    	]);

        event(new Remittance($request->loan_id));

    	return Response::json($query);	
    }

    public function getDates()
    {
        return $query = DB::table('remittance_dates')
                ->select('remittance_dates.*')
                ->get();
    }

    public function getCorrespondingDate($date_id)
    {
        return $query = DB::table('remittance_dates')
                          ->select('remittance_dates.remittance_date')
                          ->whereIn('remittance_dates.id', $date_id)
                          ->get();
    }

}
