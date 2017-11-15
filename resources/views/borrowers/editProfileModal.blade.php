<div class="modal fade text-left" id="editProfileModal" tabindex="-1" role="dialog" arialabeledby="editProfileModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editProfileModalLabel">Edit Borrower Profile</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
			</div>
			<div class="modal-body" style="font-size: 0.9rem !important;">
        <form id="editBorrowerProfileForm" novalidate>
        		<div class="form-group">
              <label>Name</label>
              <input type="text" id="editBorrowerName" name="editBorrowerName" class="form-control">
           </div>
           <div class="form-group">       
             <label>Address</label>
             <input type="text" id="editBorrowerAddress" name="editBorrowerAddress" class="form-control">
           </div>
           <div class="form-group">       
             <label>Contact Details</label>
             <input type="text" id="editBorrowerContact" name="editBorrowerContact" class="form-control">
           </div>
          </form>
      		</div>
      		<div class="modal-footer">
	        	<button type="button" id="editButton" class="btn btn-primary">Save Changes</button>
      		</div>
		</div>		
	</div> 
</div>