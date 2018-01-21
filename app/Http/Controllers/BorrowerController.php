<?php

namespace App\Http\Controllers;

use App\Events\AddBorrower;
use App\Events\EditProfile;
use App\Http\Controllers\CompanyController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class BorrowerController extends Controller
{
	// Auth Middleware restricts access to this controller to only authorized users
    public function __construct()
    {
    	$this->middleware('auth');
    }

    // Create a new Borrower and insert it into the database
    public function create(Request $request)
    {
        // Insert the new borrower record into the database
        $newBorrower = DB::table('borrowers')->insertGetId(
            [
                'name' => (isset($request->addBorrowerFormName)?$request->addBorrowerFormName:$request->addBorrowerName1),
                // 'company_id' => ($request->addBorrowerFormCompany == "0" ?null: $request->addBorrowerFormCompany)
                'company_id' => (isset($request->addBorrowerFormCompany)?$request->addBorrowerFormCompany:$request->addBorrowerCompany1)
            ]
        );

        // Fire the Add Borrower event
        event(new AddBorrower($newBorrower));

        // Return the json result
        return Response::json($newBorrower);
    }

    // Get the borrowers for each company
    public function getBorrowersByCompany(Request $request)
    {
        // For the borrowers dropdown in add loan modal
        if (is_numeric($request->selectedCompany))
        {
            $query = DB::table('borrowers')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->where('borrowers.company_id', '=', ($request->selectedCompany == "0"? null: $request->selectedCompany))
                    ->select('borrowers.*')
                    ->get();

            return Response::json($query);
        }

        // For the Company List
        elseif($request->remittanceDate == "master")
        {
            $query = DB::table('loans')
                    ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('remittance_dates', 'loans.remittance_date_id', '=', 'remittance_dates.id')
                    ->where('companies.name', '=', $request->selectedCompany)
                    ->groupBy('borrowers.name', 'borrowers.id')
                    ->selectRaw("GROUP_CONCAT(DISTINCT(remittance_dates.remittance_date) SEPARATOR ', ') as remittance_dates, borrowers.name as name, borrowers.id as id");

            return DataTables::of($query)->make(); 
        }

        // For the company list
        elseif($request->remittanceDate != "master")
        {
            $query = DB::table('loans')
                    ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('remittance_dates', 'loans.remittance_date_id', '=', 'remittance_dates.id')
                    ->where([
                        ['companies.name', '=', $request->selectedCompany],
                        ['remittance_dates.id', '=', $request->remittanceDate]
                    ])
                    ->selectRaw("DISTINCT(remittance_dates.remittance_date) as remittance_dates, borrowers.name as name");

            return DataTables::of($query)->make(); 
            // return Response::json($request->remittanceDate);
        }
        else
        {
            return Response::json('Failed');
        }

    }

    // Gets all the borrower's profile details
    public function getBorrowerDetails($id)
    {
        return DB::table('borrowers')
                ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                ->where('borrowers.id', $id)
                ->select('borrowers.*', 'companies.name as company')
                ->get();
    }

    // View Borrower's Loan History
    public function loans($id)
    {
        return view('borrowers.loans')->with('borrowerId', $id);
    }


    // View borrower's profile page
    public function profile($id)
    {
        $profile = $this->getBorrowerDetails($id);

        return view('borrowers.profile')->with('profile', $profile->first());
    }


    // Get the loans and cash advances count of a borrower
    public function readLoans($id)
    {
        $arr_data = [];

        // Count all of the borrowers loans
        $getLoanStat = DB::table('loans')
                    ->where('borrower_id', $id)
                    ->selectRaw('count(loans.id) as loan_count, MAX(loans.created_at) as latest_loan')
                    ->first();

        // // Count all of the borrowers cash advances
        // $arr_data[] = DB::table('cash_advances')
        //             ->leftJoin('loans', 'cash_advances.loan_id', '=', 'loans.id')
        //             ->where('borrower_id', $id)
        //             ->select('loan_id')
        //             ->count();

        // Count all of the borrower's loan remittances except 0.00
        $getLoanRemitStat = DB::table('loan_remittances')
                        ->leftJoin('loans', 'loan_remittances.loan_id', '=', 'loans.id')
                        ->where([
                            ['loans.borrower_id', $id],
                            ['loan_remittances.amount', '!=', 0.00]
                        ])
                        ->selectRaw('count(loan_remittances.id) as loan_remit_count, MAX(loan_remittances.date) as latest_loan_remit')
                        ->first();

        $arr_data[0] = $getLoanStat->loan_count;
        $arr_data[1] = Carbon::parse($getLoanStat->latest_loan)->diffForHumans();
        $arr_data[2] = $getLoanRemitStat->loan_remit_count;
        $arr_data[3] = Carbon::parse($getLoanRemitStat->latest_loan_remit)->diffForHumans();

        return Response::json($arr_data);
    }

    // Displays the borrowers page
    public function show()
    {
        $companies = (new CompanyController)->getCompanies();

    	return view('borrowers.index', compact('companies'));
    }

    // Updates the borrower's profile
    public function updateProfile($id, Request $request)
    {
        event(new EditProfile($id));

        return Response::json(
            DB::table('borrowers')
                ->where('id', $id)
                ->update([   
                    'name' => $request->editBorrowerName,
                    'contact_details' => $request->editBorrowerContact,
                    'address' => $request->editBorrowerAddress
                ])
        );
    }	

}
