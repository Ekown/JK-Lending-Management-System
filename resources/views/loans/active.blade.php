@extends('layouts.master')


@section ('content')

{{--     @include ('addLoanModal') --}}

    <div id="flash-message" class="clearfix"></div>

    <section class="charts">

        <div class="container-fluid">

            <header>
                <h1 class="h1">Active Remittable Loans Master List</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 currentRemittanceDate" style="margin-bottom: 30px;">
                    Current Remittance Date: <span id="remittance_date" style="font-size: 120% !important;"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-responsive" id="datatable" cellspacing="0" width="100%" style="font-size: 12px !important;">
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

            var remittanceDates = [];

            // Dynamically create and update the date badge
            function changeDateBadge()
            {
                $.ajax({
                    method: "POST",
                    url: "{{ route('getCorrespondingDate') }}",
                    async: false,
                    success: function(res) {
                        // console.log(res);

                        var html = "";

                        if(res[0] != null)
                        {
                            for(var i = 0, len = res.length; i < len; i++) 
                            {
                               html += "&nbsp;<span class='badge badge-primary'>"+res[i].remittance_date+"</span>";

                               remittanceDates.push(res[i].remittance_date);
                            }
                        }
                        else
                        {
                            html = "<span class='badge badge-danger'>No Remittance Today</span>";
                        }    

                         $('#remittance_date').html(html);
                        
                    }
                });
            }

            changeDateBadge();

            // Instantiate the server side DataTable
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('masterActiveList') }}",
                    // data: { remittance_date :  } 
                    async: false             
                },
                dom: 'Bfrtip',
                buttons: [ 
                    {
                        extend: 'print',
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '15pt' );
                            //     // .prepend(
                            //     //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                            //     // );
                            
                            // Add the remarks column header
                            $(win.document.body).find('table thead tr').append("<th>Remarks</th>");

                            // Add rows to the remarks column
                            $(win.document.body).find('table tbody tr').each(function() { 
                                $(this).append("<td></td>") 
                            });
                                
                        },
                        messageTop: function() {
                            var companyName = '';

                            if($('#companyDropdown').val() == "")
                                companyName = 'All';
                            else
                                companyName = $('#companyDropdown').val();

                            return 'Company: ' + companyName + ' <br> Pay-out: ' + remittanceDates;
                        },
                        exportOptions: {
                            columns: function() {
                                // if($('#companyDropdown').val() == "")
                                //     return [ 0, 1, 2, 7, 10 ];
                                // else
                                    return [ 0, 1, 7, 10 ];
                            }()
                        },
                        title: function() {
                            return 'JK Lending';
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
                    { "data": "cash_advance_status", "name" : "cash_advance_status.name" },
                    // { "data": "loan_status", "name" : "loan_status.name" }
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

                        // console.log(aData.loan_status);

                        // If the current row's loan status is late, turn the background color to red
                        if(aData.loan_status == "Late")
                            $(nRow).attr("style", "background-color: #f79191");
                    }
                    
                    return nRow;
                },
                "initComplete" : function() {
                    var select = jQuery("<select id='companyDropdown' style='margin-right: 10px'><option value=''>-No Filter-</option></select>");

                    this.api().column(2).data().unique().sort().each( function ( d, j ) {
                         select.append( '<option value="'+d+'">'+d+'</option>' )
                     });

                    $(document).find('div.dt-buttons').prepend(select).on('change', function() {
                        table.search( $('#companyDropdown').val() ).draw();
                    });

                },
                "pageLength" : 15,
                "bLengthChange": false  
            }); 

            table.buttons().container()
                .appendTo( '#datatable_wrapper .dt-buttons btn-group' );

            // $(document).find('div.dt-buttons').prepend("<select class='selectize' id='companyDropdown'></select>");

                  
            // Makes the datatable row clickable
            $('#datatable').on('click', 'tbody tr', function() {
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
        
            // Listens for updates in the active remittable loans table in the database
            Echo.private(`loanMasterListChannel`)
            .listen('UpdateActiveLoans', (e) => {
                // console.log(e);
                changeDateBadge();
                $('#datatable').DataTable().draw(false);
                
                alert('<strong>Active</strong> loans have been updated for today. [{{ \Carbon\Carbon::today()->format('m-d-Y') }}]');

            })
            // Listens for significant remittances
            .listen('Remittance', (e) => {
                // console.log(e);
                $('#datatable').DataTable().draw(false);

                if(e.updateLoanStatus == "Paid")
                    alert('A remittance was made. Loan #' + e.loanId + ' is now fully paid.');
                else if (e.updateLoanStatus == "Not Fully Paid")
                    alert('A remittance for Loan #' + e.loanId + ' was made.');

            });   

        });
    </script>
@endpush
