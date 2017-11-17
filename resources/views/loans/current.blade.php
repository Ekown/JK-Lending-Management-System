@extends('layouts.master')


@section ('content')

    <div id="flash-message" class="clearfix"></div>

@include ('loans.addLoanModal')

    <section class="charts">
        
        <div class="container-fluid">

            <header>
                <h1 class="h1">Current Loans Master List</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="datatable table table-hover table-responsive" cellspacing="0" width="100%" role="grid" style="width: 100% !important; font-size: 12px;">
                                <thead class="thead-dark">
                                    <tr>                    
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Date of Loan</th>
                                        <th>Loan Amount</th>   
                                        <th>Interested Amount (Return)</th>   
                                        <th>Percentage</th>
                                        <th>Deduction Amount</th>
                                        <th>Term Type</th>
                                        <th>Term</th>
                                        {{-- <th>Loan Status</th> --}}
                                        <th>Cash Advance Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>        

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Instantiate the server side DataTable
            var table = $('.datatable').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('masterList') }}",
                    async: true             
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Loan Record',
                        action: function (e, dt, node, config) {
                            $('#addLoanModal').modal('show')
                        }
                    }
                ],
                "columns": [
                    { "data": "id", "name" : "loans.id" },
                    { "data": "borrower_name", "name" : "borrowers.name" },
                    { "data": "company_name", "name" : "companies.name" },
                    { "data": "created_at", "name" : "loans.created_at" },
                    { "data": "amount", "name" : "loans.amount" },                    
                    { "data": "interested_amount", "name" : "loans.interested_amount" },             
                    { "data": "percentage", "name" : "loans.percentage" },
                    { "data": "deduction", "name" : "loans.deduction" }, 
                    { "data": "term_type", "name" : "term_type.name" },
                    { "data": "term", "name" : "loans.term" },                 
                    // { "data": "loan_status", "name" : "loan_status.name" },                  
                    { "data": "cash_advance_status", "name" : "cash_advance_status.name" }
                ],
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if(aData != null)
                    {
                        var id = aData.id;

                        var loanAmount = aData.amount;
                        var interestedAmount = aData.interested_amount;
                        var deductionAmount = aData.deduction;
                        var percentage = aData.percentage;

                        $(nRow).attr("data-loan-id", id);
                        $(nRow).find("td:nth-child(5)").html("{{ peso() }}" + (+loanAmount).toFixed(2));
                        $(nRow).find("td:nth-child(6)").html("{{ peso() }}" + (+interestedAmount).toFixed(2));
                        $(nRow).find("td:nth-child(7)").html(percentage + "%");
                        $(nRow).find("td:nth-child(8)").html("{{ peso() }}" + (+deductionAmount).toFixed(2));
                    }
                    
                    return nRow;
                },
                "pageLength" : 15  
            });

            // Instantiate the Remittance Date Dropdown
            $('#addRemittanceDate1, #addRemittanceDate2').selectize({
                // Enable the user to add new remittance dates into the dropdown
                create: function(input, callback){
                    // var lastRemittanceDateId = function() {
                    //     var tmp = null;
                    //     $.ajax({
                    {{-- //         url: "{{ route('getLastRemittanceDateId') }}", --}}
                    //         method: 'POST',
                    //         global: false,
                    //         async: false,
                    //         success: function(data){
                    //             tmp = data.id;
                    //             //console.log(tmp);
                    //         },
                    //         error: function() {
                    //             console.log("error");
                    //         }
                    //     });
                    //     return tmp;
                    // }();
                    // console.log(lastRemittanceDateId+1);
                    callback({
                        'value': input,     
                        'text': input   
                    });
                }
            });

            // Submit a POST AJAX request to add the loan record
            $('#submitAddLoanForm').click(function() {

                // Check which form is filled-up and submitted
                if($('#new').hasClass('active'))
                {
                    // var form = $('#addLoanRecordForm1');
                    var form = 'addLoanRecordForm1';
                    // if($('#addBorrowerName1').val() == "")
                    //     console.log('no borrower name');
                }
                else if($('#existing').hasClass('active'))
                {
                    // var form = $('#addLoanRecordForm2');
                    var form = 'addLoanRecordForm2';                   
                }

                if(addLoanValidate(form) == true)
                {
                    // AJAX request for submiting the loan form
                    $.ajax({
                        method: "POST",
                        url: "{{ route('addLoan') }}",
                        data: $('#'+form).serialize(),
                        success: function(){
                            console.log("success");
                            $('.datatable').DataTable().draw(false);
                            // Hide the modal after submitting
                            $('#addLoanModal').modal('hide')
                        },
                        error: function(){
                            console.log("error");
                        }
                    });
                }
                
            });

            // Instantiate the borrower dropdown
            var $select = $('#addBorrowerName2').selectize();
            var selectize = $select[0].selectize;
            var defaultBorrowers = [];    

            // Instantiate the company dropdown for new borrowers
            var $newCompanyDropdown = $('#addBorrowerCompany1').selectize();
            var newCompanyDropdownSelectize = $newCompanyDropdown[0].selectize;  

            // Instantiate the company dropdown for old borrowers
            var $oldCompanyDropdown = $('#addBorrowerCompany2').selectize();
            var oldCompanyDropdownSelectize = $oldCompanyDropdown[0].selectize; 

            var defaultCompanies = [];      

            // Instantiate the Selectize Plugin
            $('#addLoanTermType1, #addLoanTermType2').selectize({
              sortField: 'text'
            });
            
            // Ajax call for borrowers by company
            function ajaxCallForBorrowers(){
               $.ajax({
                  method: "POST",
                  url: "{{ route('getBorrowersByCompany') }}",
                  data: { selectedCompany : $('#addBorrowerCompany2').val() },
                  dataType: 'json',
                  success: function (data){
                      selectize.clearOptions();

                      defaultBorrowers = data;
                      selectize.addOption({value: 0, text: "-Please choose a borrower-"});
                      defaultBorrowers.forEach(function(entry)
                      {
                          selectize.addOption({value: entry.id, text: entry.name});
                      });
                      selectize.refreshOptions();
                      selectize.addItem(0);
                  }
               }); 
            } 

            function getCompaniesForDropdown()
            {
                $.ajax({
                  method: "POST",
                  url: "{{ route('getCompaniesForDropdown') }}",
                  dataType: 'json',
                  success: function (data){
                      newCompanyDropdownSelectize.clearOptions();  
                      oldCompanyDropdownSelectize.clearOptions();

                      defaultCompanies = data;

                      newCompanyDropdownSelectize.addOption({value: 7, text: "-No Company (Default)-"});
                      oldCompanyDropdownSelectize.addOption({value: 7, text: "-No Company (Default)-"});

                      defaultCompanies.forEach(function(entry)
                      {
                          newCompanyDropdownSelectize.addOption({value: entry.id, text: entry.name});
                          oldCompanyDropdownSelectize.addOption({value: entry.id, text: entry.name});
                      });

                      newCompanyDropdownSelectize.refreshOptions();
                      newCompanyDropdownSelectize.addItem(0);
                      newCompanyDropdownSelectize.setValue(7);

                      oldCompanyDropdownSelectize.refreshOptions();
                      oldCompanyDropdownSelectize.addItem(0);
                      oldCompanyDropdownSelectize.setValue(7);
                  }
               });
            }     

            // Call the function
            ajaxCallForBorrowers();
            getCompaniesForDropdown();     

            // When the company dropdown is changed, the function is called again
            $('#addBorrowerCompany2').change(function (){
                selectize.clearOptions();
                ajaxCallForBorrowers();
            });     

            // Reload(Reset) the page when the "cancel" button is pressed in the modal
            $('#resetAddLoanForm').on('click', function() {
              location.reload(true);
            });

            // Makes the datatable row clickable
            $('.datatable').on('click', 'tbody tr', function() {
                if(table.data().count())
                {
                    // console.log(table.data().count());
                    window.location = "/loan/record/" + $(this).data("loan-id");
                }
            });

            function alert(msg)
            {
                $('<div class="alert">' 
                    + msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').appendTo('#flash-message').trigger('showalert');           
            }

            $(document).on('showalert', '.alert', function(){
                    window.setTimeout($.proxy(function() {
                        $(this).fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove(); 
                        });
                    }, this), 5000);
            }); 
            

            // Listens for updates from the server and redraws the datatable
            Echo.private(`loanMasterListChannel`)
            .listen('Remittance', (e) => {
                // console.log(e);
                $('.datatable').DataTable().draw(false);
                
                if(e.updateLoanStatus == "Paid")
                    alert('A remittance was made. Loan #' + e.loanId + ' is now fully paid and moved to the Finished Loans.');
            })
            .listen('AddLoanRecord', (e) => {

                // Update the datatable
                $('.datatable').DataTable().draw(false);
                
                // Flash message when a new loan is made
                alert("A new loan (#" + e.loanId + ") for <strong>" + e.borrower + "</strong> was made.");
            })
            .listen('AddCompany', (e) => {
                
                // Update the company dropdowns
                getCompaniesForDropdown();

                // Flash message when a new company is added
                alert( '<strong>' + e.company[0].name + '(#' + e.company[0].id + ')</strong> was added to the company list');
            });
            
            Echo.private(`borrowerMasterListChannel`)
            .listen('AddBorrower', (e) => {

                // Update the borrowers dropdown
                ajaxCallForBorrowers();
                
                // Flash message when a new borrower is added
                alert( e.borrower[0].name + ' was added to ' + e.borrower[0].company + ' in the borrower list');
            });    

        });
    </script>

@endpush

