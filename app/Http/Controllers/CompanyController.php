<?php

namespace App\Http\Controllers;

use App\Events\AddCompany;
use App\Http\Controllers\RemittanceController;
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
        $query = DB::table('companies')->insertGetId(
            [
                'name' => $request->addCompanyFormName
            ]
        );

        event(new AddCompany($query));

        return Response::json($query);
    }

    public function getCompanies()
    {
        // Gets all the existing companies in the database
        return $companies = DB::table('companies')
                        ->orderBy('companies.name', 'asc')
                        ->get();
    }

    // Show the companies
    public function show($company = null, $date = null)
    {
        if ($company == null && $date == null)
            return view('companies.index');
        elseif ($company != null && $date != null)
        {
            $remittanceDates = (new RemittanceController)->getDates();

            $companyId = DB::table('companies')->where('name', $company)->select('id')->get();

            return view('companies.companies')->with('company', $company)->with('dates', $remittanceDates)->with('remitDate', $date)->with('companyId', $companyId);
        }
    }

    
}
