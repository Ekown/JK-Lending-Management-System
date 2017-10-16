@extends ('layouts.master')


@section ('content')

<div class="modal fade" id="remitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remit to Loan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form id="remitLoanForm">
      		<div class="form-control">
      			<div class="form-group">
      				<label for="remitLoanDate" class="form-control-label">Date of Loan Remittance:</label>
                    <input name="remitLoanDate" id="remitLoanDate" class="form-control datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
      			</div>
      			<div class="form-group">
      				<label for="remitLoanAmount" class="form-control-label">Loan Remittance Amount:</label>
                    <input type="number" name="remitLoanAmount" id="remitLoanAmount" class="form-control" value="{{ $details->first()->deduction }}">
      			</div>
      		</div>
      	</form>    
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="resetRemitForm">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitRemitForm">Remit</button>
      </div>
      </div>
    </div>
  </div>



<div class="container">
	<h2>Loan Details</h2>

	<div class="row loan-details">
		<ul class="list-group col-md-3">
		  <li class="list-group-item border-0"><b>Loan ID:</b> {{ $details->first()->id }}</li>
		  <li class="list-group-item border-0"><b>Date of Loan:</b> {{ $details->first()->created_at }}</li>
		  <li class="list-group-item border-0"><b>Borrower Name:</b> {{ $details->first()->borrower_name }}</li>
		  <li class="list-group-item border-0"><b>Borrower Company:</b> {{ $details->first()->company_name }}</li> 
		  <li class="list-group-item border-0">
		  	<b>Term:</b> {{ ($details->first()->term) }} 
				@if ($details->first()->term_type_id == 1)
					{{ "month/s" }}
				@else
					{{ "give/s" }}
				@endif
		  </li>
      <li class="list-group-item border-0">
        <b>Remittance Date:</b> {{ $details->first()->remittance_date }}
      </li>
		  <li class="list-group-item border-0"><hr></li>
		  <li class="list-group-item border-0">
		  	<b>Loan Status:</b> 
			<span class="badge" id="loan_status">{{ $details->first()->loan_status }}</span>
		  </li>
		  <li class="list-group-item border-0"><b>Loan Percentage:</b> {{ $details->first()->percentage }}%</li>
		  <li class="list-group-item border-0"><b>Loan Amount:</b> {{ peso().number_format($details->first()->amount, 2) }}</li>
		  <li class="list-group-item border-0"><b>Interested Amount:</b> {{ peso().number_format($details->first()->interested_amount, 2) }}</li>
		</ul>

		<div class="col-md-9">
			<table class="datatable table table-hover" cellspacing="0" role="grid" style="width:100%">
				<thead class="thead-inverse">
					<tr>
						<th>#</th>
						<th>Date of Remittance</th>
						<th>Remittance Amount</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
        <tfoot>
          <tr>
            <th colspan="2"></th>
            <th id="totalSumColumn"></th>
          </tr>
          <tr >
            <th colspan="2" style="border: none !important"></th>
            <th id="totalSumColumn" style="border: none !important"></th>
          </tr>
        </tfoot>
			</table>
		</div>
	</div>
</div>	 

@endsection

@push ('scripts')
	<script>
		$(document).ready(function (){

      function updateBadge(){
        // Dynamically change the badge of the loan status
        if($('#loan_status').html() == "Not Paid")
        {
          $('#loan_status').attr("class", "badge badge-warning");
        }
        else if ($('#loan_status').html() == "Late")
        {
          $('#loan_status').attr("class", "badge badge-danger");
        }
        else if($('#loan_status').html() == "Paid")
        {
          $('#loan_status').attr("class", "badge badge-success");
        }
      } 

      updateBadge();

			// Instantiate the server side DataTable
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "/loan/" + {{ $details->first()->id }} + "/remittances",
                    async: false            
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Remit to Loan',
                        action: function (e, dt, node, config) {
                            $('#remitModal').modal('show')
                        }
                    }
                ],
                "columns": [
                    { "data": "id", "name" : "loan_remittances.id" },
                    { "data": "date", "name" : "loan_remittances.date" },
                    { "data": "amount", "name" : "loan_remittances.amount" }
                ],
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if(aData != null)
                    {
                      var amount = aData.amount;
                      $(nRow).find("td:nth-child(3)").html("{{ peso() }}" + (+amount).toFixed(2));
                      console.log(nRow);
                      return nRow;
                    }
                      
                },
                "drawCallback": function (settings) {
                    // Get the DataTable API instance
                    var api = this.api();

                    var balance = {{ $loanBalance->first()->interested_amount }};
                    var res = null;

                    var remittances = function() {
                      var tmp = null;
                      $.ajax({
                          'async': false,
                          'type': "POST",
                          'global': false,
                          'url': "/loan/" + {{ $details->first()->id }} + "/remittances/sum",
                          'success': function (data) {
                              tmp = data[0].sum;
                              console.log(data[0].sum);
                          }
                      });
                      return tmp;
                    }();

                    // if (balance <= remittances)
                    //   res = 0;
                    // else
                    //   res = balance - remittances;

                    res = balance - remittances;

                    if(remittances != null)
                    {
                      // Redraw the footer with the updated draw data
                      $( api.table().footer() ).find('th').eq(0).html( "Total Remittance Amount: ");
                      $( api.table().footer() ).find('th').eq(1).html("{{ peso() }}" + remittances.toFixed(2));
                    }
                      $( api.table().footer() ).find('th').eq(2).html( "Total Remaining Balance: ");
                      $( api.table().footer() ).find('th').eq(3).html("{{ peso() }}" + res.toFixed(2));
                    
                  
                },
                "pageLength": 7
                // "footerCallback": function( tfoot, data, start, end, display ) {
                //   $(tfoot).find('th').eq(0).html( "Total Remittance Amount: ");
                //   $(tfoot).find('th').eq(1).html({{ $totalRemittances->first()->sum }});
                // } 
            });

            $('.datepicker').datepicker();

            // Submit a POST AJAX request to add the loan record
            $('#submitRemitForm').click(function() {

                // Hide the modal after submitting
                $('#remitModal').modal('hide');

                // AJAX request for submiting the loan form
                $.ajax({
                    method: "POST",
                    url: "{{ route('remitLoan') }}",
                    data: $('#remitLoanForm').serialize() + "&loan_id={{ $details->first()->id }}",
                    success: function(result){
                        console.log("success");
                        $('.datatable').DataTable().draw(false);
                        // window.location = "/loan/" + {{ $details->first()->id }};
                    },
                    error: function(){
                        console.log("error");
                    }
                });
            });

      Echo.private(`loanChannel.{{ $details->first()->id }}`)
      .listen('Remittance', (e) => {
          // console.log(e);
          $('.datatable').DataTable().draw(false);
          $('#loan_status').html(e.updateLoanStatus);
          updateBadge();
      });

		});
	</script>
@endpush