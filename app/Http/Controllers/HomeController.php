<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RemittanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = (new CompanyController)->getCompanies();

        $remittanceDates = (new RemittanceController)->getDates();

        return view('home')->with('companies', $companies)->with('remittanceDates', $remittanceDates);
    }
}
