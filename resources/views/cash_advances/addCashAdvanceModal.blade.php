<div class="modal fade" id="addCashAdvanceModal" role="dialog" arialabeledby="addCashAdvanceModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addCashAdvanceModalTitle">Add Cash Advances</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
			</div>
			<div class="modal-body">
        		<form id="addCashAdvanceForm" novalidate>
        			<div class="form-group col">
        				<label for="addCashAdvanceDate" class="form-control-label">Cash Advance Date:</label>
        				<input name="addCashAdvanceDate" id="addCashAdvanceDate" class="form-control datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
        				<div class="invalid-feedback" id="name-error-msg">
	                      Please enter a valid date
	                    </div>
        			</div>

        			<div class="form-group col">
        				<label for="addCashAdvanceAmount" class="form-control-label">Cash Advance Amount:</label>
        				<input type="number" name="addCashAdvanceAmount" id="addCashAdvanceAmount" class="form-control">
        				<div class="invalid-feedback" id="name-error-msg">
	                      Please enter a valid cash advance amount
	                    </div>
        			</div>
        		</form>
      		</div>
      		<div class="modal-footer">
	        	<button type="button" class="btn btn-primary" id="addCashAdvanceSubmitForm">Submit</button>
      		</div>
		</div>		
	</div> 
</div>