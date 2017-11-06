<?php

namespace App\Http\Controllers;

use App\Events\AddLoanRecord;
use App\Events\UpdateActiveLoans;
use App\Http\Controllers\BorrowerController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $exists = false;

        // Check if the given remittance date exists in the database
        $existingRemittanceDate = DB::table('remittance_dates')
                                  ->select('id')
                                  ->get();
 
        for($i = 0; $i < count($existingRemittanceDate); $i++) 
        {
            if((string)$existingRemittanceDate[$i]->id == (isset($request->addRemittanceDate1)?(string)$request->addRemittanceDate1:(string)$request->addRemittanceDate2))
            {
                $exists = true;
            }
        }

        // If it doesn't exist, it is considered to be a customized date and will be inserted into    // the database
        if($exists == false)
        {
            $addNewRemittanceDate = DB::table('remittance_dates')
                                    ->insertGetId(
                                        [
                                            'remittance_date' => (isset($request->addRemittanceDate1)?$request->addRemittanceDate1:$request->addRemittanceDate2)
                                        ]
                                    );
        }

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
        	$createLoanRecord = DB::table('loans')->insertGetId(
        		[
        			'borrower_id' => $borrower_id->first()->id,
        			'amount' => $request->addLoanAmount1,
        			'term' => $request->addBorrowerTerm1,
                    'term_type_id' => $request->addLoanTermType1,
                    'remittance_date_id' => ($exists == true?$request->addRemittanceDate1:
                        $addNewRemittanceDate),
        			'percentage' => $request->addBorrowerPercentage1,
                    'deduction' => $interested_amount/($request->addBorrowerTerm1 * 2),
                    'interested_amount' => $interested_amount,
        			'created_at' => $request->addBorrowerDate1
        		]
        	);
    	}
    	// If the loan is for an existing borrower
    	else
    	{
            // Calculate the interested amount
            $interested_amount = $request->addLoanAmount2 + ($request->addLoanAmount2 * ($request->addBorrowerPercentage2/100));

    		$createLoanRecord = DB::table('loans')->insertGetId(
        		[
        			'borrower_id' => $request->addBorrowerName2,
        			'amount' => $request->addLoanAmount2,
        			'term' => $request->addBorrowerTerm2,
                    'term_type_id' => $request->addLoanTermType2,
                    'remittance_date_id' => ($exists == true?$request->addRemittanceDate2:$addNewRemittanceDate),
        			'percentage' => $request->addBorrowerPercentage2,
                    'deduction' => $interested_amount/($request->addBorrowerTerm2 * 2),
                    'interested_amount' => $interested_amount,
        			'created_at' => $request->addBorrowerDate2
        		]
        	);
    	}

        // If the added loan record is of the current remittance id then insert it into the active 
        // table
        for($i = 0; $i < count(remittance_date_id()); $i++)
        {
            if(remittance_date_id()[$i] == (isset($request->addRemittanceDate1)?$request->addRemittanceDate1:$request->addRemittanceDate2))
            {
                $insertIntoActive = DB::table('active_remittable_loans')
                                      ->insert([
                                            [
                                                'loan_id' => $createLoanRecord,
                                                'remittance_date_id' => remittance_date_id()[$i],
                                                'date' => Carbon::today('Asia/Manila')->format('Y-m-d')
                                            ]
                                          ]);

                event(new UpdateActiveLoans(false));

                break;
            }
        }

        event(new AddLoanRecord((isset($borrower_id)?$borrower_id->first()->id:$request->addBorrowerName2)));      

        return Response::json($createLoanRecord);  
        
    }

}
