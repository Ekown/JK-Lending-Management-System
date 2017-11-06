<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    // Auth Middleware restricts access to this controller to only authorized users
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showActiveLoanMasterList()
    {
        // Gets all the latest active ledgers with their associated column data from other tables
        $query = DB::table('active_remittable_loans')
                    ->leftJoin('loans', 'active_remittable_loans.loan_id', '=', 'loans.id')
                    ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('cash_advance_status', 'loans.cash_advance_status_id', '=', 'cash_advance_status.id')
                    ->leftJoin('term_type', 'loans.term_type_id', '=', 'term_type.id')
                    ->leftJoin('loan_status', 'loans.loan_status_id', '=', 'loan_status.id')
                    ->select('loans.*', 'borrowers.name as borrower_name', 'companies.name as company_name', 'cash_advance_status.name as cash_advance_status', 'term_type.name as term_type', 'loan_status.name as loan_status');

        // Returns an instance of the DataTable class with the ledger data
        return DataTables::of($query)->make();
    }

    public function showFinishedLoanMasterList()
    {
        // Gets all the latest finished ledgers with their associated column data from other tables
        $query = DB::table('loans')
                    ->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('cash_advance_status', 'loans.cash_advance_status_id', '=', 'cash_advance_status.id')
                    ->leftJoin('term_type', 'loans.term_type_id', '=', 'term_type.id')
                    ->leftJoin('loan_status', 'loans.loan_status_id', '=', 'loan_status.id')
                    ->where('loans.loan_status_id', '=', 2)
                    ->select('loans.*', 'borrowers.name as borrower_name', 'companies.name as company_name', 'cash_advance_status.name as cash_advance_status', 'term_type.name as term_type', 'loan_status.name as loan_status');

        return DataTables::of($query)->make();
    }

    public function showLoanRemittances($loan_id)
    {
        // Gets all the loan remittances of the given loan id
        $query = DB::table('loan_remittances')
                    ->where('loan_id', $loan_id)
                    ->select('loan_remittances.id', 'loan_remittances.date', 'loan_remittances.amount');
        // Returns an instance of the DataTable class with the loan remittances data            
        return DataTables::of($query)->make();
    }

    // Returns an instance of the Current Loan Master List DataTable
    public function showLoanMasterList()
    {
    	// Gets all the latest current ledgers with their associated column data from other tables
    	$query = DB::table('loans')
    				->leftJoin('borrowers', 'loans.borrower_id', '=', 'borrowers.id')
    				->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->leftJoin('cash_advance_status', 'loans.cash_advance_status_id', '=', 'cash_advance_status.id')
                    ->leftJoin('term_type', 'loans.term_type_id', '=', 'term_type.id')
    				->leftJoin('loan_status', 'loans.loan_status_id', '=', 'loan_status.id')
                    ->whereIn('loans.loan_status_id', [1,3])
    				->select('loans.*', 'borrowers.name as borrower_name', 'companies.name as company_name', 'cash_advance_status.name as cash_advance_status', 'term_type.name as term_type', 'loan_status.name as loan_status');

    	// Returns an instance of the DataTable class with the ledger data
        return DataTables::of($query)->make();
    }

    // Gets all the existing borrowers in the database
    public function showMasterBorrowerList()
    {
        $query = DB::table('borrowers')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')
                    ->select('borrowers.*', 'companies.name as company_name');

        return DataTables::of($query)->make();
    }

    // Returns an instance of the Master Cash Advance List DataTable
    public function showMasterCashAdvanceList()
    {
        // Gets all the latest cash advances with their associated column data from other tables
        $query = DB::table('cash_advances')
                    ->leftJoin('loans', 'cash_advances.id', '=', 'loans.cash_advance_id')
                    ->leftJoin('borrowers', 'ledgers.borrower_id', '=', 'borrowers.id')
                    ->leftJoin('companies', 'borrowers.company_id', '=', 'companies.id')    
                    ->select('cash_advances.*', 'borrowers.borrower_name', 'companies.company_name')
                    ->latest('cash_advances.cash_advance_date');

        // Returns an instance of the DataTable class with the cash advance data
        return DataTables::of($query)->make();
    }

    public function showMasterCompanyList()
    {
        // Gets all the companies with their associated column data from other tables
        $query = DB::table('companies')
                    ->selectRaw('companies.name, count(borrowers.id) as count')
                    ->leftJoin('borrowers', 'companies.id', '=', 'borrowers.company_id')
                    ->groupBy('companies.name');

        // Returns an instance of the DataTable class with the company data
        return DataTables::of($query)->make();
    }
}
