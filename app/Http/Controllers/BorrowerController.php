<?php

namespace App\Http\Controllers;

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
        return Response::json(DB::table('borrowers')->insert([
            [
                'name' => $request->addBorrowerName1,
                'company_id' => ($request->addBorrowerCompany1 == "0" ?null: $request->addBorrowerCompany1)
            ]
        ]));
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
                ->first();
    }

    public function loans($id)
    {
        return view('borrowers.loans')->with('borrowerId', $id);
    }

    public function profile($id)
    {
        $profile = $this->getBorrowerDetails($id);

        return view('borrowers.profile')->with('profile', $profile);
    }

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

}
