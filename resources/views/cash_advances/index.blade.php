@extends ('layouts.master')

@section ('content')

    <div id="flash-message" class="clearfix"></div>

{{-- @include('cash_advances.addCashAdvanceModal') --}}

    <section class="charts">

        <div class="container-fluid">

            <header>
                <h1 class="h1">Cash Advance List</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="datatable table table-hover" cellspacing="0"
                                width="100%" role="grid" style="width: 100% !important; font-size: 12px;">
                                <thead class="thead-dark">
                                    <tr>                    
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Company</th>
                                        <th>Date</th>
                                        <th>Cash Advance Amount</th>
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

@push ('scripts')
	<script>
		$(document).ready(function (){

			// Instantiate the server side DataTable
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('master_ca_list') }}",
                    async: false             
                },
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         text: 'Add Cash Advance',
                //         action: function (e, dt, node, config) {
                //             $('#addCashAdvanceModal').modal('show')
                //         }
                //     }
                // ],
                "columns": [
                    { "data": "id", "name" : "cash_advances.id" },
                    { "data": "borrower", "name" : "borrowers.name" },
                    { "data": "company", "name" : "companies.name" },
                    { "data": "date", "name" : "cash_advance_amount.date" },
                    { "data": "amount", "name" : "cash_advance_amount.amount" }
                ],
                "pageLength" : 15,
                "bLengthChange": false,
                "order" : [[ 0, "asc"]],
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if(aData != null)
                    {
                        var id = aData.loan_id;

                        $(nRow).attr("data-loan-id", id);
                    }
                    
                    return nRow;
                },
            });

            // Instantiate the bootstrap datepicker
            $('#addCashAdvanceDate').datepicker();

            $('#addCashAdvanceSubmitForm').on('click', function() {

                $('#addCashAdvanceModal').modal('hide');

                $.ajax({
                    method: "POST",
                    url: "{{ route('addCashAdvance') }}",
                    data: $('#addCashAdvanceForm').serialize(),
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(res) {
                        console.log("An error was encountered when adding the cash advance");
                    }
                });
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