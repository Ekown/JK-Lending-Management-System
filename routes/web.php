<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Home and Auth Routes
|--------------------------------------------------------------------------
*/

// Default page (login Page)
Route::get('/', function() { 
	return redirect('/login'); 
})->name('index');

// AUTH routes for login, register, forgot password, and reset password
Auth::routes();

Route::get('/home', function(){
	return redirect('/loans/list/active');
});

/*
|--------------------------------------------------------------------------
| GET Routes
|--------------------------------------------------------------------------
*/

// GET request for the home landing page for active remittable loans
Route::get('loans/list/active', 'HomeController@index')->name('home');

// GET request for the home landing page for current loans list
Route::get('loans/list/current', 'HomeController@currentLoansList')->name('currentLoansList');

// GET request for the home landing page for current loans list
Route::get('loans/list/finished', 'HomeController@finishedLoansList')->name('finishedLoansList');

// GET request for the cash advances page
Route::get('cash_advances', 'CashAdvanceController@show')->name('cashAdvances');

// GET request for the borrower list page
Route::get('borrowers', 'BorrowerController@show')->name('borrowers');

// GET request for the wild card borrower page
Route::get('borrower/{id}/profile', 'BorrowerController@profile');

// GET request for the borrower's loan list page
Route::get('borrower/{id}/loans', 'BorrowerController@loans')->name('borrowerLoans');

// GET request for the borrower's loan list page
Route::get('borrower/{id}/cash-advances', 'BorrowerController@cashAdvances')->name('borrowerCashAdvances');

// GET request for the company list page
Route::get('companies', 'CompanyController@show')->name('companies');

// GET request for the wild card company page
Route::get('companies/{company}/{date}', 'CompanyController@show');

// GET request for the wild card borrower page
Route::get('loan/record/{loan}', 'LoanController@show');



/*
|--------------------------------------------------------------------------
| AJAX Routes
|--------------------------------------------------------------------------
*/

// AJAX request for the Ledgers DataTable
Route::post('master/list/current', 'DatatableController@showLoanMasterList')->name('masterList');

Route::post('master/list/active', 'DatatableController@showActiveLoanMasterList')->name('masterActiveList');

Route::post('master/list/finished', 'DatatableController@showFinishedLoanMasterList')->name('masterFinishedLoanList');

// AJAX request for the Master Cash Advance List DataTable
Route::post('master/ca_list', 'DatatableController@showMasterCashAdvanceList')->name('master_ca_list');

// AJAX request for the Master Cash Advance List DataTable
Route::post('master/c_list', 'DatatableController@showMasterCompanyList')->name('master_c_list');

// AJAX request for the Add Loan Record
Route::post('add/loan', 'AjaxController@createLoan')->name('addLoan');

// AJAX request for the Add Loan Record
Route::post('add/loan/check/borrower', 'AjaxController@checkIfUniqueBorrower');

// AJAX request fo the Remit Loan Record
Route::post('remit/loan', 'RemittanceController@createLoan')->name('remitLoan');

// AJAX request for the Add Borrower 
Route::post('add/borrower', 'BorrowerController@create')->name('addBorrower');

// AJAX request for adding a new company
Route::post('add/company', 'CompanyController@create')->name('addCompany'); 

// AJAX request for checking if the company is unique
Route::post('add/company/check/company', 'AjaxController@checkIfUniqueCompany');

// AJAX request for adding a new cash advance
Route::post('add/cash_advance', 'CashAdvanceController@create')->name('addCashAdvance'); 

// AJAX request for getting cash advances by loan
Route::post('loan/record/{loan}/cash_advances', 'DatatableController@showCashAdvances');

// AJAX request for the getting all the companies
Route::post('get/companies', 'CompanyController@getCompanies')->name('getCompaniesForDropdown');

// AJAX request for the Borrower Master List
Route::post('get/all_borrowers', 'DatatableController@showMasterBorrowerList')->name('master_borrower_list');

// AJAX request for getting borrowers by company
Route::post('get/borrowers_by_company', 'BorrowerController@getBorrowersByCompany')
		->name('getBorrowersByCompany');

// AJAX request fo the editing the due date of a loan
Route::post('loan/record/{loan}/edit/duedate/{date}', 'LoanController@updateDueDate');

// AJAX request for getting loan remittances by loan
Route::post('loan/record/{loan}/remittances', 'DatatableController@showLoanRemittances');

// AJAX request for getting sum of remittances by loan
Route::post('loan/record/{loan}/remittances/sum', 'LoanController@readTotalRemittance');

// AJAX request for getting total late loan remittances by loan
Route::post('loan/record/{loan}/remittances/late', 'LoanController@readLateTotalRemittance');

// AJAX request for getting the borrower's number of loans
Route::post('borrower/{borrower}/profile/number/loans', 'BorrowerController@readLoans');

// AJAX request for getting the borrower's number of loans
Route::post('borrower/{borrower}/profile/number/loans', 'BorrowerController@readLoans');

// AJAX request for getting the borrower's loans
Route::post('borrower/{borrower}/profile/list/loans', 'DatatableController@showBorrowerLoansList')->name('borrowerLoanHistory');

// AJAX request for getting borrower's profile details
Route::post('borrower/{borrower}/profile/details', 'BorrowerController@getBorrowerDetails')->name('borrowerProfile');

// AJAX request for updating the  borrower's profile details
Route::post('borrower/{borrower}/profile/update/details', 'BorrowerController@updateProfile')->name('updateBorrowerProfile');

// AJAX request for getting the current remittance date
Route::post('loan/list/active/remittance_date', 'RemittanceController@getCorrespondingDate')->name('getCorrespondingDate');

// TEst for Pusher

// Route::get('event', function(){
// 	event(new Remittance('A remittance have been made!'));
// });

// Route::get('listen', function() {
// 	return view('listenBroadcast');
// });