<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CompanyController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    // Creates a Company record and inserts it into the database
    public function create(Request $request)
    {
        return Response::json($query = DB::table('companies')->insert([
            [
                'name' => $request->addCompanyFormName
            ]
        ]));
    }

    public function getCompanies()
    {
        // Gets all the existing companies in the database
        return $companies = DB::table('companies')
                        ->orderBy('companies.name', 'asc')
                        ->get();
    }

    // Show the companies
    public function show($company = null)
    {
        if ($company == null)
            return view('companies.index');
        else
            return view('companies.companies', compact('company'));
    }

    
}
