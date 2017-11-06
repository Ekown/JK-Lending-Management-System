@extends ('layouts/master')

@section('content')

    <section class="charts">
        
        <div class="container-fluid">

            <header>
                <h1 class="h1">Finished Loans Master List</h1>
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
	$(document).ready(function(){

		var table = $('.datatable').DataTable({
			"autoWidth": true,
            processing: true,
            serverSide: true,
            ajax : {
            	method: 'POST',
            	url: "{{ route('masterFinishedLoanList') }}",
            	async: false
            },
            // dom: 'Bfrtip',
            // buttons: [
            //     {
            //         text: 'Add Loan Record',
            //         action: function (e, dt, node, config) {
            //             $('#addLoanModal').modal('show')
            //         }
            //     }
            // ],
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
                "pageLength" : 15,
                "bLengthChange": false
		});

        // Makes the datatable row clickable
        $('.datatable').on('click', 'tbody tr', function() {
            if(table.data().count())
            {
                // console.log(table.data().count());
                window.location = "/loan/record/" + $(this).data("loan-id");
            }
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

