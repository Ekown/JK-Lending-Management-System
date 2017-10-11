<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BorrowerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{
	// Auth Middleware restricts access to this controller to only authorized users
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Creates a new loan record and appends it into the database
    public function createLoan(Request $request)
    {

    	// If the loan is for a new borrower
    	if ($request->addBorrowerCompany1 != null)
    	{
    		// Create a borrower 
    		$createBorrower = (new BorrowerController)->create($request);

    		// Get the newly created borrower's id
        	$borrower_id = DB::table('borrowers')
        					->where('name', '=', $request->addBorrowerName1)
        					->get();

            // Calculate the interested amount
            $interested_amount = $request->addLoanAmount1 + ($request->addLoanAmount1 * ($request->addBorrowerPercentage1/100));

        	// Create a new loan record
        	$createLoanRecord = DB::table('loans')->insert([
        		[
        			'borrower_id' => $borrower_id->first()->id,
        			'amount' => $request->addLoanAmount1,
        			'term' => $request->addBorrowerTerm1,
                    'term_type_id' => $request->addLoanTermType1,
        			'percentage' => $request->addBorrowerPercentage1,
                    'deduction' => $interested_amount/($request->addBorrowerTerm1 * 2),
                    'interested_amount' => $interested_amount,
        			'created_at' => $request->addBorrowerDate1
        		]
        	]);

        	return Response::json($createLoanRecord);
    	}
    	// If the loan is for an existing borrower
    	else
    	{
            // Calculate the interested amount
            $interested_amount = $request->addLoanAmount2 + ($request->addLoanAmount2 * ($request->addBorrowerPercentage2/100));

    		$createLoanRecord = DB::table('loans')->insert([
        		[
        			'borrower_id' => $request->addBorrowerName2,
        			'amount' => $request->addLoanAmount2,
        			'term' => $request->addBorrowerTerm2,
                    'term_type_id' => $request->addLoanTermType2,
        			'percentage' => $request->addBorrowerPercentage2,
                    'deduction' => $interested_amount/($request->addBorrowerTerm2 * 2),
                    'interested_amount' => $interested_amount,
        			'created_at' => $request->addBorrowerDate2
        		]
        	]);

        	return Response::json($createLoanRecord);
    	}
        
    }

}
