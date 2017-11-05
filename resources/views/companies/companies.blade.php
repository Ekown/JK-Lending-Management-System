@extends ('layouts.master')

@section ('content')

    <section class="charts">

        <div class="container-fluid">

            <header>
                <h1 class="h1">Company Name: {{ $company }}</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
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
                    "bLengthChange": false
                    // "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                    //     var id = aData.company_name;
                    //     $(nRow).attr("data-company-name", id);
                    //     return nRow;
                    // }, 
                    
      
                });    
            // }

            selectizeControl.on('change', function(){
                // console.log(selectizeControl.getValue());
                window.location = selectizeControl.getValue();
            });

			

		});
	</script>
@endpush	