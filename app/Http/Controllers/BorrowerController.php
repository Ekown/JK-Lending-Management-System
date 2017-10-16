<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CompanyController;
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
                    ->groupBy('borrowers.name')
                    ->selectRaw("GROUP_CONCAT(DISTINCT(remittance_dates.remittance_date) SEPARATOR ', ') as remittance_dates, borrowers.name as name");

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

    // Displays the borrowers page
    public function show()
    {
        $companies = (new CompanyController)->getCompanies();

    	return view('borrowers.index', compact('companies'));
    }	

}
