@extends ('layouts.master')


@section ('content')

  @include('cash_advances.addCashAdvanceModal')
  
  <div id="flash-message" class="clearfix"></div>

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

  <div class="modal fade" id="dueDateModal" role="dialog" arialabeledby="dueDateModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="dueDateModalTitle">Manually Enter the Due Date</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body">
          <form id="dueDateModalForm" method="POST">
            <div class="container-fluid">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  <div class="form-group">
                    <div class="form-control">
                      <label for="loanDueDate" class="form-control-label">Due Date:</label>
                      <input name="loanDueDate" id="loanDueDate" class="form-control datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="dueDateModalSubmitForm" class="btn btn-primary">Save Changes</button>
        </div>
      </div>    
    </div> 
  </div>

  <div class="modal fade" id="deleteLoanModal" role="dialog" arialabeledby="deleteLoanModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteLoanModalTitle">Delete This Loan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this loan?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="deleteLoanModalConfirm">Yes</button>
        </div>
      </div>    
    </div> 
  </div>

  <div class="modal fade" id="deleteLoanRemittanceModal" role="dialog" arialabeledby="deleteLoanRemittanceModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteLoanRemittanceModalTitle">Delete This Loan Remittance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this loan remittance?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-primary" id="deleteLoanModalRemittanceConfirm">Yes</button>
        </div>
      </div>    
    </div> 
  </div>

  <section class="charts">

    <div class="container-fluid">

      <header>
        <div class="row">
          <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
            <h1 class="h1">Loan #{{ $details->first()->id }}</h1>
          </div>
          
          {{-- Delete Loan Button --}}
          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <span id="deleteLoanButton" data-toggle="tooltip" data-placement="left" title="Delete this loan"><button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button></span>
          </div>
        </div>
      </header>

      <div class="row">
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <div class="card" style="font-size: smaller;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: rgba(0,0,0,.02);">
              Loan Information
            </div>
            <div class="card-body">
              <ul class="list-group">
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
                <li class="list-group-item border-0"><strong>Due Date:</strong> {{ $details->first()->due_date }} 
                  @if($details->first()->due_date != null )
                    ({{ \Carbon\Carbon::parse($details->first()->due_date)->diffForHumans() }})
                  @else
                    <span class="badge badge-warning" id="due_date">No Due Date</span>
                  @endif
                </li> 
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
            <div class="card-header d-flex justify-content-between align-items-center" style="font-size: smaller; background-color: rgba(0,0,0,.02);">
              Loan Remittances
            </div>
            <div class="card-body">
              <table class="loanRemitDatatable table" cellspacing="0" role="grid" style="width:100%">
                <thead class="thead-dark">
                  <tr>
                    <th>#</th>
                    <th>Date of Remittance</th>
                    <th>Remittance Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr class="totalSumColumn">
                    <th colspan="2"></th>
                    <th id="totalSumColumn"></th>
                    <th></th>
                  </tr>
                  <tr class="totalSumColumn">
                    <th colspan="2" style="border: none !important"></th>
                    <th id="totalSumColumn" style="border: none !important"></th>
                    <th style="border: none !important"></th>
                  </tr>
                  <tr class="text-danger">
                    <th colspan="2" style="border: none !important"></th>
                    <th style="border: none !important"></th>
                    <th style="border: none !important"></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: rgba(0,0,0,.02); font-size: smaller">
              Cash Advances
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <table class="cashAdvancesDatatable table table-hover" cellspacing="0" role="grid" style="width:100%">
                    <thead class="thead-dark">
                      <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Cash Advance Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    {{-- <tfoot>
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
                    </tfoot> --}}
                  </table>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <table class="datatable table table-hover" cellspacing="0" role="grid" style="width:100%">
                    <thead class="thead-dark">
                      <tr>
                        <th>Date</th>
                        <th>Cash Advance Remittance</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    {{-- <tfoot>
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
                    </tfoot> --}}
                  </table>
                </div>
              </div>
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

      function format(d){
        console.log(d.loan_id);
         // `d` is the original data object for the row
         var tableHtml = function() {
            var tmp = '';

            tmp = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

            // for(var i = 0; i < )
            // {

            // }
            //          '<tr>' +
            //              '<td>Date:</td>' +
            //              '<td>' + d.name + '</td>' +
            //          '</tr>' +
            //       '</table>';

            return tmp;
         }();

         return tableHtml;  
      }

      function alert(msg) {
          $('<div class="alert">' 
            + msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').appendTo('#flash-message').trigger('showalert');           
      }

			// Instantiate the server side Loan Remittance DataTable
      var loanRemittanceTable = $('.loanRemitDatatable').DataTable({
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
                    { "data": "amount", "name" : "loan_remittances.amount" },
                    { 
                      "data": null,
                      "render": function () {
                        return '<span id="deleteLoanRemittanceButton" data-toggle="tooltip" data-placement="bottom" title="Delete this remittance"><button type="button" class="close" aria-label="Close"><i style="color: red;" class="fa fa-times" aria-hidden="true"></i></button></span>';
                      },
                      "orderable": false
                    }
                ],
                select: true,
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).find("td:nth-child(4) button").css("float", "unset");

                    if(aData != null)
                    {
                      var amount = aData.amount;
                      var id = aData.id;
                      if(amount != "0")
                          $(nRow).find("td:nth-child(3)").html("{{ peso() }}" + (+amount).toFixed(2));
                      else
                          $(nRow).find("td:nth-child(3)").html("<span style='color:red'>No Remittance</span>");

                      $(nRow).find("td:nth-child(4) button").attr("remittance-id", id);
                      
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
                      $( api.table().footer() ).find('th').eq(3).html( "Total Remaining Balance: ");
                      $( api.table().footer() ).find('th').eq(4).html("{{ peso() }}" + res.toFixed(2));

                    if(lateRemittances != 0 && lateRemittances != null)
                    {
                      console.log(lateRemittances);
                      $( api.table().footer() ).find('th').eq(6).html( "Total Late Remittance Amount: ");
                      $( api.table().footer() ).find('th').eq(7).html("{{ peso() }}" + lateRemittances.toFixed(2));
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

      // Instantiate the server side Cash Advances DataTable
      var cashAdvanceTable = $('.cashAdvancesDatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            method : "POST",
            url : {{ $details->first()->id }} + "/cash_advances",
            async: false            
        },
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Add Cash Advance',
                action: function (e, dt, node, config) {
                    $('#addCashAdvanceModal').modal('show')
                }
            }
        ],
        "columns": [
            {
              "className": 'details-control',
              "orderable": false,
              "data": null,
              "defaultContent": '',
              "render": function () {
                  return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
              },
              width:"15px"
            },
            { "data": "date", "name" : "cash_advance_amount.date" },
            { "data": "amount", "name" : "cash_advance_amount.amount" }
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

        },
        "pageLength": 10,
        "order": [[ 1, "asc" ]]
        // "footerCallback": function( tfoot, data, start, end, display ) {
        //   $(tfoot).find('th').eq(0).html( "Total Remittance Amount: ");
        //   $(tfoot).find('th').eq(1).html({{ $totalRemittances->first()->sum }});
        // } 
      });

      updateBadge();

      /********************* EVENT LISTENERS *********************/

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

      // Submit a POST AJAX request to add the cash advance record
      $('#addCashAdvanceSubmitForm').click(function() {
        // Hide the modal after submitting
        $('#addCashAdvanceModal').modal('hide');

        // AJAX request for submiting the cash advance
        $.ajax({
          method: "POST",
          url: "{{ route('addCashAdvance') }}",
          data: $('#addCashAdvanceForm').serialize() + "&loan_id={{ $details->first()->id }}",
          success: function(data) {
            console.log($('#addCashAdvanceAmount').val() + " was added as cash advance.");
          },
          error: function(res) {
            console.log("There was an error encountered while adding the cash advance.");
          }
        });
      });

      $(document).on('showalert', '.alert', function(){
              window.setTimeout($.proxy(function() {
                  $(this).fadeTo(500, 0).slideUp(500, function(){
                      $(this).remove(); 
                  });
              }, this), 5000);
      });

      // Show the due date modal form when the badge is clicked
      $('#due_date').on('click', function(){
        if($('#due_date').html() == "No Due Date")
          $('#dueDateModal').modal('show');
        // console.log('Show the modal');
      });

      // Show the delete loan modal form 
      $('#deleteLoanButton').on('click', function(){
          $('#deleteLoanModal').modal('show');
        // console.log('Show the modal');
      });

      // Show the delete loan remittance modal form 
      $('.loanRemitDatatable').on( 'click', 'tbody tr td span button', function () {
          $('#deleteLoanRemittanceModal').modal('show');

          $('.loanRemitDatatable').attr("remittance-id", $(this).attr("remittance-id"));

          // loanRemittanceTable.row( this ).delete( {
          //     buttons: [
          //         { label: 'Cancel', fn: function () { this.close(); } },
          //         'Delete'
          //     ]
          // } );
      } );

      $('#deleteLoanModalConfirm').on('click', function(){
        $('#deleteLoanModal').modal('hide');

        $.ajax({
          url: "{{ route('deleteLoan', ['loan_id' => $details->first()->id ]) }}",
          method: "POST",
          success: function(data) {
            console.log(data);
            window.location = "{{ route('currentLoansList') }}"
          },
          error: function(res) {
            console.log("An error was encountered when deleting this loan.");
          }
        });
      });

      $('#deleteLoanModalRemittanceConfirm').on('click', function(){
        $('#deleteLoanRemittanceModal').modal('hide');

        $.ajax({
          url: "{{ route('deleteLoanRemittance') }}",
          data: { remittance_id :  $('.loanRemitDatatable').attr("remittance-id") },
          method: "POST",
          success: function(data) {
            $('.loanRemitDatatable').DataTable().draw(false);
            alert("Remittance #" + $('.loanRemitDatatable').attr("remittance-id") + " has been deleted" );
          },
          error: function(res) {
            console.log("An error was encountered when deleting this loan.");
          }
        });
      });

      // Submit the form when the submit button is clicked
      $('#dueDateModalSubmitForm').on('click', function(){
        $('#dueDateModal').modal('hide');

        $.ajax({
          method: "POST",
          url: "http://jklending.prod:81/loan/record/{{ $details->first()->id }}/edit/duedate/"
            + $('#loanDueDate').val(),
          success: function(data) {
            //console.log(data);
            $('#due_date').html($('#loanDueDate').val());
            $('#due_date').attr('class', '');
          },
          error: function(res) {
            console.log("An error was encountered when updating the due date. Try again.");
          }
        });
      });

      // Add event listener for opening and closing details
      $('.cashAdvancesDatatable tbody').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var tdi = tr.find("i.fa");
          var row = cashAdvanceTable.row(tr);

          if (row.child.isShown()) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass('shown');
              tdi.first().removeClass('fa-minus-square');
              tdi.first().addClass('fa-plus-square');
          }
          else {
              // Open this row
              row.child(format(row.data())).show();
              tr.addClass('shown');
              tdi.first().removeClass('fa-plus-square');
              tdi.first().addClass('fa-minus-square');
          }
      });

      cashAdvanceTable.on("user-select", function (e, dt, type, cell, originalEvent) {
          if ($(cell.node()).hasClass("details-control")) {
              e.preventDefault();
          }
      });

      // Instantiate the bootstrap datepicker API
      $('.datepicker').datepicker();

      // Render any tooltips in the page
      $('[data-toggle="tooltip"]').tooltip();

      Echo.private(`loanChannel.{{ $details->first()->id }}`)
      .listen('Remittance', (e) => {
          // console.log(e);
          $('.loanRemitDatatable').DataTable().draw(false);

          if(e.updateLoanStatus != null)
            $('#loan_status').html(e.updateLoanStatus);
          
          updateBadge();

          if(e.updateLoanStatus == "Paid")
            alert('A remittance was made today. This loan is now fully paid and moved to the Finished Loans.');
          else if(e.updateLoanStatus == "Not Fully Paid")
            alert("A remittance was made today.");
      })
      .listen('AddCashAdvance', (e) => {
          // console.log(e);
          $('.cashAdvancesDatatable').DataTable().draw(false);

          alert("A new cash advance was added to Loan #{{ $details->first()->id }}");
      });

		});
	</script>
@endpush