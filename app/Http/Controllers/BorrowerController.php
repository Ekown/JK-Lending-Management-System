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
        if (is_numeric($request->selectedCompany))
        {
            $query = DB::table('borrowers')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->where('borrowers.company_id', '=', ($request->selectedCompany == "0"? null: $request->selectedCompany))
                    ->select('borrowers.*')
                    ->get();

            return Response::json($query);
        }
        else
        {
            $query = DB::table('borrowers')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->where('companies.name', '=', $request->selectedCompany)
                    ->select('borrowers.*');

            return DataTables::of($query)->make(); 
        }
        
    }

    // Displays the borrowers page
    public function show()
    {
        $companies = (new CompanyController)->getCompanies();

    	return view('borrowers.index', compact('companies'));
    }	

}
