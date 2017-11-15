@extends ('layouts.master')


@section ('content')

    <div id="flash-message" class="clearfix"></div>

    <section class="charts">

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
                            <div class="invalid-feedback" id="name-error-msg"></div>
                        </div>
                    </form>
                  </div>
            
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitAddCompanyForm">Submit</button>
                  </div>
                </div>
          </div>
        </div>

        <div class="container-fluid">

            <header>
                <h1 class="h1">Company List</h1>
            </header>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="datatable table table-hover" cellspacing="0" width="100%" role="grid" style="width: 100%;">
                                <thead class="thead-dark">
                                    <tr>                    
                                        <th>Name</th>
                                        <th># of Borrowers</th>
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

                if(addCompanyValidate() == true)
                {
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

            $('.datatable').on('click', 'tbody tr', function() {
                if(table.data().count())
                {
                    window.location = "/companies/" + $(this).data("company-name") + "/master";
                }
            });

            Echo.private(`borrowerMasterListChannel`)
            .listen('AddBorrower', (e) => {
                
                $('.datatable').DataTable().draw(false);
                
                alert( e.borrower[0].name + ' was added to ' + e.borrower[0].company + ' in the borrower list'); 
            });

            Echo.private(`companyMasterListChannel`)
            .listen('AddCompany', (e) => {
                
                $('.datatable').DataTable().draw(false);
                
                alert( '<strong>' + e.company[0].name + '(#' + e.company[0].id + ')</strong> was added to the company list'); 
            });
		});
	</script>
@endpush