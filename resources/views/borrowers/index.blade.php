@extends ('layouts.master')


@section ('content')
    <div class="modal fade" id="addBorrowerModal" tabindex="-1" role="dialog" aria-labelledby=" exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Borrower</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="addBorrowerForm" style="padding-top: 1em;">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="addBorrowerFormCompany" class="form-control-label">Borrower Company:</label>
                        <select class="form-control" id="addBorrowerFormCompany" name="addBorrowerCompany1">
                          <option value="1">-No Company (Default)-</option>
            
                          @foreach ($companies as $company)
                            @if ($company->id != 1)
                              <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endif
                          @endforeach
            
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="addBorrowerFormName" class="form-control-label">Borrower Name:</label>
                        <input type="text" class="form-control" id="addBorrowerFormName" name="    addBorrowerName1">
                      </div>
                </form>
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="resetAddBorrowerForm"> Cancel</button>
            <button type="button" class="btn btn-primary" id="submitAddBorrowerForm">Submit</button>
          </div>
        </div>
      </div>
    </div>

	<h2>Borrower List</h2>

	<div class="container-fluid">
        <table class="datatable table-striped" cellspacing="0" width="100%" role="grid" style="width: 100%;">
            <thead class="thead-inverse">
                <tr>                    
                    <th>Name</th>
                    <th>Company</th>
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
                    url : "{{ route('master_borrower_list') }}"             
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Borrower',
                        action: function (e, dt, node, config) {
                            $('#addBorrowerModal').modal('show')
                        }
                    }
                ],
                "columns": [
                    { "data": "name", "name" : "borrowers.name" },
                    { "data": "company_name", "name" : "companies.name" }
                ] 
            });

            // Instantiate the selectize plugin for the company dropdown
            $('#addBorrowerFormCompany').selectize();

            $('#submitAddBorrowerForm').click(function (){

                // Hide the modal after submitting
                $('#addBorrowerModal').modal('hide');

                // AJAX request for submiting the loan form
                $.ajax({
                  method: "POST",
                  url: "{{ route('addBorrower') }}",
                    data: $('#addBorrowerForm').serialize(),
                    success: function(){
                        console.log("success");
                        $('.datatable').DataTable().draw(false);
                    },
                    error: function(){
                        console.log("error");
                        $('.datatable').DataTable().draw(false);
                    }
                });
            });
		});
	</script>
@endpush


