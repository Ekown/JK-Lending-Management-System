<div class="modal fade" id="addLoanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Loan Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="addLoanRecordFormTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="new-borrower-tab" data-toggle="tab" href="#new" role="tab">New Borrower</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="existing-borrower-tab" data-toggle="tab" href="#existing" role="tab">Existing Borrower</a>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="addLoanFormTabContent">
            <div class="tab-pane fade show active" id="new" role="tabpanel">
                <form id="addLoanRecordForm1" style="padding-top: 1em;" novalidate>
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label for="addBorrowerCompany1" class="form-control-label">Borrower Company:</label>
                    <select class="form-control" id="addBorrowerCompany1" name="addBorrowerCompany1">
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="addBorrowerName1" class="form-control-label">Borrower Name:</label>
                    <input type="text" class="form-control" id="addBorrowerName1" name="addBorrowerName1">
                    <div class="invalid-feedback" id="name-error-msg">
                      Please enter a valid borrower name (no numbers and blank name)
                    </div>
                  </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addBorrowerDate1" class="form-control-label">Date of Loan:</label>
                        <input name="addBorrowerDate1" id="addBorrowerDate1" class="form-control    datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
                      </div>
                      <div class="form-group col">
                        <label for="addLoanAmount1" class="form-control-label">Loan Amount:</label>
                        <input type="number" name="addLoanAmount1" id="addLoanAmount1" class="form-control" required>
                        <div class="invalid-feedback">
                          Please enter a valid loan amount (no negative and big numbers)
                        </div>
                      </div>
                      <div class="form-group col">
                         <label for="addBorrowerPercentage1" class="form-control-label">Percentage:</label>
                         <input type="number" class="form-control" id="addBorrowerPercentage1" name="       addBorrowerPercentage1" required>
                         <div class="invalid-feedback">
                          Please enter a valid percentage (1-100 only)
                        </div>
                       </div>
                    </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addLoanTermType1" class="form-control-label">Term Type: 
                       </label>
                          <select class="form-control" id="addLoanTermType1" name="addLoanTermType1" required>
                            <option value="1">-By Month (Default)-</option>
                            <option value="2">By Give</option>
                          </select>
                       </div>
                       <div class="form-group col">
                        <label for="addBorrowerTerm1" class="form-control-label">Term: 
                       </label>       
                         <input type="number" class="form-control" id="addBorrowerTerm1" name="     addBorrowerTerm1" step="0.5" required>
                         <div class="invalid-feedback">
                          Please enter a valid term (no negative and blank)
                        </div>
                       </div>
                       <div class="form-group col">
                         <label for="addRemittanceDate1" class="form-control-label">Remittance Date:</label>
                         <select class="form-control" id="addRemittanceDate1" name="addRemittanceDate1" required>
                          @foreach ($remittanceDates as $date)
                              <option value="{{ $date->id }}">{{ $date->remittance_date }}</option>
                          @endforeach
                          </select>
                       </div>
                    </div>
                </form>      
            </div>
            <div class="tab-pane fade" id="existing" role="tabpanel">
                <form id="addLoanRecordForm2" style="padding-top: 1em;">
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label for="addBorrowerCompany2" class="form-control-label">Borrower Company:</label>
                    <select class="form-control" id="addBorrowerCompany2" name="addBorrowerCompany2" required>
                    </select>
                  </div>
                  <div class="form-group" style="margin-top: -5px;">
                    <label for="addBorrowerName2" class="form-control-label">Borrower Name:</label>
                    <select class="form-control" id="addBorrowerName2" name="addBorrowerName2" required>
                    </select>
                  </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addBorrowerDate2" class="form-control-label">Date of Loan:</label>
                        <input name="addBorrowerDate2" id="addBorrowerDate2" class="form-control    datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd" required>
                      </div>
                      <div class="form-group col">
                        <label for="addLoanAmount2" class="form-control-label">Loan Amount:</label>
                        <input type="number" name="addLoanAmount2" id="addLoanAmount2" class="form-control" required>
                        <div class="invalid-feedback">
                          Please enter a valid loan amount (no negative and big numbers)
                        </div> 
                      </div>
                      <div class="form-group col">
                         <label for="addBorrowerPercentage2" class="form-control-label">Percentage:</label>
                         <input type="number" class="form-control" id="addBorrowerPercentage2" name="addBorrowerPercentage2" required>
                         <div class="invalid-feedback">
                          Please enter a valid percentage (1-100 only)
                        </div>
                       </div>
                    </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addLoanTermType2" class="form-control-label">Term Type: 
                       </label>
                          <select class="form-control" id="addLoanTermType2" name="addLoanTermType2" required>
                            <option value="1">-By Month (Default)-</option>
                            <option value="2">By Give</option>
                          </select>
                       </div>
                      <div class="form-group col">
                         <label for="addBorrowerTerm2" class="form-control-label">Term:</label>
                         <input type="number" class="form-control" id="addBorrowerTerm2" name="     addBorrowerTerm2" step="0.5" required> 
                         <div class="invalid-feedback">
                          Please enter a valid term (no negative and blank)
                        </div>
                       </div>
                       <div class="form-group col">
                         <label for="addRemittanceDate2" class="form-control-label">Remittance Date:</label>
                         <select class="form-control" id="addRemittanceDate2" name="addRemittanceDate2" required>
                            @foreach ($remittanceDates as $date)
                              <option value="{{ $date->id }}">{{ $date->remittance_date }}</option>
                            @endforeach
                          </select>
                       </div>
                    </div>
                </form>  
            </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="resetAddLoanForm">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitAddLoanForm">Submit</button>
      </div>
    </div>
  </div>
</div>