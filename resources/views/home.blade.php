@extends('layouts.master')


@section ('content')

    @include ('addLoanModal')

    <div class="container-fluid">

      <h2>Current Loans Master List</h2>
        <table class="datatable table mdl-data-table__cell--non-numeric table-hover" cellspacing="0"
            width="100%" role="grid" style="width: 100% !important; font-size: 12px;">
            <thead class="thead-inverse">
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


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Instantiate the server side DataTable
            $('.datatable').DataTable({
                "autoWidth": true,
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('masterList') }}"             
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
                "pageLength" : 8  
            });

            // Instantiate the DatePicker Plugin 
            $('.datepicker').datepicker();

            // Submit a POST AJAX request to add the loan record
            $('#submitAddLoanForm').click(function() {

                // Hide the modal after submitting
                $('#addLoanModal').modal('hide')

                // Check which form is filled-up and submitted
                if($('#new').hasClass('active'))
                {
                    var form = $('#addLoanRecordForm1');
                }
                else if($('#existing').hasClass('active'))
                {
                    var form = $('#addLoanRecordForm2');
                }

                // AJAX request for submiting the loan form
                $.ajax({
                    method: "POST",
                    url: "{{ route('addLoan') }}",
                    data: form.serialize(),
                    success: function(){
                        console.log("success");
                        $('.datatable').DataTable().draw(false);
                    },
                    error: function(){
                        console.log("error");
                    }
                });
            });

            var $select = $('#addBorrowerName2').selectize();
            var selectize = $select[0].selectize;
            var defaultBorrowers = [];


            // Instantiate the Selectize Plugin
            $('#addBorrowerCompany1, #addBorrowerCompany2, #addLoanTermType1, #addLoanTermType2').selectize({
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

            // Call the function
            ajaxCallForBorrowers();     

            // When the company dropdown is changed, the function is called again
            $('#addBorrowerCompany2').change(function (){
                selectize.clearOptions();
                ajaxCallForBorrowers();
            });     

            // Makes the datatable row clickable
            $('.datatable').on('click', 'tbody tr', function() {
              window.location = "/loan/" + $(this).data("loan-id");
            }); 

            // Reload(Reset) the page when the "cancel" button is pressed in the modal
            $('#resetAddLoanForm').on('click', function() {
              location.reload(true);
            });

            // Listens for updates from the server and redraws the datatable
            Echo.private(`loanMasterListChannel`)
            .listen('Remittance', (e) => {
                // console.log(e);
                $('.datatable').DataTable().draw(false);
            });    

        });
    </script>
@endpush
