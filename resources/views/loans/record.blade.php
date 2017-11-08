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

  <section class="charts">

    <div class="container-fluid">

      <header>
        <h1 class="h1">Loan Details</h1>
      </header>

      <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <div class="card" style="font-size: smaller;">
            <div class="card-body">
              <ul class="list-group">
                <li class="list-group-item border-0"><strong>Loan ID:</strong> {{ $details->first()->id }}</li>
                <li class="list-group-item border-0"><strong>Date of Loan:</strong> {{ $details->first()->created_at }}</li>
                <li class="list-group-item border-0"><strong>Borrower Name:</strong> {{ $details->first()->borrower_name }}</li>
                <li class="list-group-item border-0"><strong>Borrower Company:</strong> {{ $details->first()->company_name }}</li> 
                <li class="list-group-item border-0">
                  <strong>Term:</strong> {{ ($details->first()->term) }} 
                  @if ($details->first()->term_type_id == 1)
                    {{ "month/s" }}
                  @else
                    {{ "give/s" }}
                  @endif
                </li>
                <li class="list-group-item border-0"><strong>Due Date:</strong> {{ $details->first()->due_date }} ({{ \Carbon\Carbon::parse($details->first()->due_date)->diffForHumans() }})</li> 
                <li class="list-group-item border-0">
                  <strong>Remittance Date:</strong>
                   <span class="badge badge-primary">{{ $details->first()->remittance_date }}</span> 
                </li>
                <li class="list-group-item border-0"><hr></li>
                <li class="list-group-item border-0">
                  <strong>Loan Status:</strong> 
                <span class="badge" id="loan_status">{{ $details->first()->loan_status }}</span>
                </li>
                <li class="list-group-item border-0"><strong>Loan Percentage:</strong> {{ $details->first()->percentage }}%</li>
                <li class="list-group-item border-0"><strong>Deduction Amount:</strong> {{ peso().number_format($details->first()->deduction, 2) }}</li>
                <li class="list-group-item border-0"><strong>Loan Amount:</strong> {{ peso().number_format($details->first()->amount, 2) }}</li>
                <li class="list-group-item border-0"><strong>Interested Amount:</strong> {{ peso().number_format($details->first()->interested_amount, 2) }}</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
          <div class="card">
            <div class="card-body">
              <table class="datatable table table-hover" cellspacing="0" role="grid" style="width:100%">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Date of Remittance</th>
                    <th>Remittance Amount</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr class="totalSumColumn">
                    <th colspan="2"></th>
                    <th id="totalSumColumn"></th>
                  </tr>
                  <tr class="totalSumColumn">
                    <th colspan="2" style="border: none !important"></th>
                    <th id="totalSumColumn" style="border: none !important"></th>
                  </tr>
                  <tr class="text-danger">
                    <th colspan="2" style="border: none !important"></th>
                    <th style="border: none !important"></th>
                  </tr>
                </tfoot>
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

      function updateBadge(){
        // Dynamically change the badge of the loan status
        if($('#loan_status').html() == "Not Fully Paid")
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
          $('.remitLoan').attr("hidden", "hidden");
        }
      }

			// Instantiate the server side DataTable
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : {{ $details->first()->id }} + "/remittances",
                    async: false            
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Remit to Loan',
                        action: function (e, dt, node, config) {
                            $('#remitModal').modal('show')
                        },
                        className: 'remitLoan'
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
                      if(amount != "0")
                          $(nRow).find("td:nth-child(3)").html("{{ peso() }}" + (+amount).toFixed(2));
                      else
                          $(nRow).find("td:nth-child(3)").html("<span style='color:red'>No Remittance</span>");
                      
                      // console.log(nRow);
                      return nRow;
                    }
                      
                },
                "drawCallback": function (settings) {
                    // Get the DataTable API instance
                    var api = this.api();

                    var balance = {{ $loanBalance->interested_amount }};
                    var res = null;

                    var remittances = function() {
                      var tmp = null;
                      $.ajax({
                          'async': false,
                          'type': "POST",
                          'global': false,
                          'url': {{ $details->first()->id }} + "/remittances/sum",
                          'success': function (data) {
                            if(data != null)
                              tmp = data[0].sum;
                              // console.log(data[0].sum);
                          }
                      });
                      return tmp;
                    }();

                    var lateRemittances = function() {
                      var tmp = 0;
                      $.ajax({
                          'async': false,
                          'type': "POST",
                          'global': false,
                          'url': {{ $details->first()->id }} + "/remittances/late",
                          'success': function (data) {
                            if(data != 0)
                              tmp = data[0].amount;
                              // console.log(data[0].sum);
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

                    if(lateRemittances != 0 && lateRemittances != null)
                    {
                      console.log(lateRemittances);
                      $( api.table().footer() ).find('th').eq(4).html( "Total Late Remittance Amount: ");
                      $( api.table().footer() ).find('th').eq(5).html("{{ peso() }}" + lateRemittances.toFixed(2));
                    }
                    else
                    {
                      console.log("Hide the late");
                      $('.text-danger').attr("hidden", "hidden");
                    }
                    
                  
                },
                "pageLength": 10,
                "order": [[ 1, "asc" ]]
                // "footerCallback": function( tfoot, data, start, end, display ) {
                //   $(tfoot).find('th').eq(0).html( "Total Remittance Amount: ");
                //   $(tfoot).find('th').eq(1).html({{ $totalRemittances->first()->sum }});
                // } 
            });

            updateBadge();

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
                        console.log( "₱" + $('#remitLoanAmount').val() + " was remitted for Loan #" + {{ $details->first()->id }} + ".");
                    },
                    error: function(){
                        console.log("There was an error encountered. Remittance for Loan #" + {{ $details->first()->id }} + " failed.");
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