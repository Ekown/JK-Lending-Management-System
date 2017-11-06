@extends ('layouts.master')


@section ('content')

    <section class="charts">

        <div class="container-fluid">

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

            <header>
                <h1 class="h1">Borrower List</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover" id="datatable" cellspacing="0" width="100%" role="grid" style="width: 100% !important;">
                                <thead class="thead-dark">
                                <tr>                    
                                    <th>Name</th>
                                    <th>Company</th>
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
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    method : "POST",
                    url : "{{ route('master_borrower_list') }}",
                    async: false             
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
                ],
                "pageLength" : 15,
                "fnRowCallback" : function (nRow, aData, iDisplayIndex, iDisplayIndexFull){
                    if(aData != null)
                    {
                        var id = aData.id;

                        $(nRow).attr("data-borrower-id", id);
                    }
                },
                "order" : [[ 0, "asc"]]
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

            // Makes the datatable row clickable
            $('#datatable').on('click', 'tbody tr', function() {
                if(table.data().count())
                  {
                    // console.log($(this).data("borrower-id"));
                    window.location = "/borrower/" + $(this).data("borrower-id") + "/profile";
                  }
            });
		});
	</script>
@endpush


