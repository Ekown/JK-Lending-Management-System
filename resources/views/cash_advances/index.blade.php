@extends ('layouts.master')

@section ('content')
	<h2>Cash Advances</h2>

	<div class="container-fluid">
        <table class="datatable table-striped" cellspacing="0"
            width="100%" role="grid" style="width: 100%;">
            <thead class="thead-inverse">
                <tr>                    
                    <th>Name</th>
                    <th>Company</th>
                    <th>Date of Loan</th>
                    <th>Cash Advance Amount</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@push ('scripts')
	<script>
		$(document).ready(function (){

			// Instantiate the server side DataTable
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('master_ca_list') }}"             
                },
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         text: 'Add Loan Record',
                //         action: function (e, dt, node, config) {
                //             $('#addBorrowerModal').modal('show')
                //         }
                //     }
                // ],
                "columns": [
                    { "data": "borrower_name", "name" : "borrowers.borrower_name" },
                    { "data": "company_name", "name" : "companies.company_name" },
                    { "data": "cash_advance_date", "name" : "cash_advances.cash_advance_date" },
                    { "data": "cash_advance_amount", "name" : "cash_advances.cash_advance_amount" }
                ] 
            });

		});
	</script>
@endpush