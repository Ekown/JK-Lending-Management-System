@extends ('layouts.master')

@section ('content')
	<h2>{{ $company }}</h2>

    <select id="remittanceDateSelector">
        
    </select>

	<div class="container-fluid">
        <table class="datatable table-hover" cellspacing="0" width="100%" role="grid" style="width: 100%;">
            <thead class="thead-inverse">
                <tr>                    
                    <th>Name</th>
                    <th>Remittance Dates</th>
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
                    data : { selectedCompany : "{{ $company }}" },  
                    url : "{{ route('getBorrowersByCompany') }}",
                    async: false             
                },
                initComplete: function () {
                    console.log(this.api().data()[2].remittance_dates);
                },
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
                ]
                // "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                //     var id = aData.company_name;
                //     $(nRow).attr("data-company-name", id);
                //     return nRow;
                // }, 
                
  
            });

		});
	</script>
@endpush	