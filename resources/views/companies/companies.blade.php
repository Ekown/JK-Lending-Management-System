@extends ('layouts.master')

@section ('content')

    <div id="flash-message" class="clearfix"></div>
    
    <section class="charts">

        <div class="container-fluid">

            <header>
                <h1 class="h1">Company Name: {{ $company }}</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2" style="margin-bottom: 30px;">
                    <strong>Sort By: </strong>
                    <select id="remittanceDateSelector">

                    @if ($remitDate == "master")
                        <option value="master" selected>-No Filter-</option>
                    @else
                        <option value="master">-No Filter-</option>
                    @endif

                    @foreach ($dates as $date)
                        @if ($date->id == $remitDate)
                            <option value="{{ $date->id }}" selected>{{ $date->remittance_date }}</option>
                        @else
                            <option value="{{ $date->id }}">{{ $date->remittance_date }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="datatable table table-hover display" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                                <thead class="thead-dark">
                                    <tr>                    
                                        <th>Name</th>
                                        <th>Remittance Dates</th>
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

            var $select = $("#remittanceDateSelector").selectize();

            var selectizeControl = $select[0].selectize;

            // var selectedDate = $('#remittanceDateSelector').val();

            // function makeTable(selectedDate)
            // {
                // Instantiate the server side DataTable
                var table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        method : "POST",
                        data : { selectedCompany : "{{ $company }}", remittanceDate : selectizeControl.getValue() },  
                        url : "{{ route('getBorrowersByCompany') }}",
                        async: false             
                    },
                    // initComplete: function () {
                    //     console.log(selectizeControl.getValue());
                    // },
                    // dom: 'Bfrtip',
                    // buttons: [
                    //     {
                    //         text: 'Add Company',
                    //         action: function (e, dt, node, config) {
                    //             $('#addCompanyModal').modal('show')
                    //         }
                    //     }
                    // ],
                    "columns": [
                        { "data": "name", "name" : "name" },
                        { "data": "remittance_dates", "name" : "remittance_dates" }
                    ],
                    "pageLength" : 15,
                    "bLengthChange": false,
                    "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if(aData != null)
                        {
                            var id = aData.id;
                            console.log(id);
                            $(nRow).attr("data-borrower-id", id);
                        }
                    }, 
                    
      
                });    
            // }

            selectizeControl.on('change', function(){
                // console.log(selectizeControl.getValue());
                window.location = selectizeControl.getValue();
            });

			// Makes the datatable row clickable
            $('.datatable').on('click', 'tbody tr', function() {
                if(table.data().count())
                  {
                    // console.log($(this).data("borrower-id"));
                    window.location = "/borrower/" + $(this).data("borrower-id") + "/profile";
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

            Echo.private(`companyChannel.{{ $companyId->first()->id }}`)
            .listen('AddBorrower', (e) => {
                
                $('.datatable').DataTable().draw(false);
                
                alert( e.borrower[0].name + ' was added to ' + e.borrower[0].company + ' in the borrower list'); 
            });

		});
	</script>
@endpush	