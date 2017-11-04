@extends ('layouts.master')


@section ('content')
    <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby=" exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Company</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addCompanyForm" style="padding-top: 1em;">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="addCompanyFormName" class="form-control-label">Company Name:</label>
                    <input type="text" class="form-control" id="addCompanyFormName" name="    addCompanyFormName">
                </div>
            </form>
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="resetAddCompanyForm"> Cancel</button>
            <button type="button" class="btn btn-primary" id="submitAddCompanyForm">Submit</button>
          </div>
        </div>
      </div>
    </div>


	<h2>Company List</h2>

	<div class="container-fluid">
        <table class="datatable table table-hover" cellspacing="0" width="100%" role="grid" style="width: 100%;">
            <thead class="thead-inverse">
                <tr>                    
                    <th>Name</th>
                    <th># of Borrowers</th>
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
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('master_c_list') }}",
                    async: false             
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Company',
                        action: function (e, dt, node, config) {
                            $('#addCompanyModal').modal('show')
                        }
                    }
                ],
                "columns": [
                    { "data": "name", "name" : "companies.name" },
                    { "data": "count", "searchable" : "false" }
                ],
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                    var id = aData.name;
                    $(nRow).attr("data-company-name", id);
                    return nRow;
                },
                "pageLength": 15 
            });

            $('#submitAddCompanyForm').click(function (){

                // Hide the modal after submitting
                $('#addCompanyModal').modal('hide');

                // AJAX request for submiting the loan form
                $.ajax({
                  method: "POST",
                  url: "{{ route('addCompany') }}",
                    data: $('#addCompanyForm').serialize(),
                    success: function(){
                        console.log("success");
                        $('.datatable').DataTable().draw(false);
                    },
                    error: function(){
                        console.log("error");
                    }
                });
            });

            $('.datatable').on('click', 'tbody tr', function() {
                if(table.data().count())
                {
                    window.location = "/companies/" + $(this).data("company-name") + "/master";
                }
            });
		});
	</script>
@endpush