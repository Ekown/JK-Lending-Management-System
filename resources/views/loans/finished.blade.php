@extends ('layouts/master')

@section('content')

	<div class="container-fluid">

      <h2>Finished Loans Master List</h2>
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
                "pageLength" : 7,
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
	});
</script>
@endpush

