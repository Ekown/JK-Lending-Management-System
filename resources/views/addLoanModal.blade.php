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
                <form id="addLoanRecordForm1" style="padding-top: 1em;">
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label for="addBorrowerCompany1" class="form-control-label">Borrower Company:</label>
                    <select class="form-control" id="addBorrowerCompany1" name="addBorrowerCompany1">
                      <option value="1">-No Company (Default)-</option>
        
                      @foreach ($companies as $company)
                        @if ($company->id != 1)
                          <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endif
                      @endforeach
        
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="addBorrowerName1" class="form-control-label">Borrower Name:</label>
                    <input type="text" class="form-control" id="addBorrowerName1" name="addBorrowerName1">
                  </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addBorrowerDate1" class="form-control-label">Date of Loan:</label>
                        <input name="addBorrowerDate1" id="addBorrowerDate1" class="form-control    datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
                      </div>
                      <div class="form-group col">
                        <label for="addLoanAmount1" class="form-control-label">Loan Amount:</label>
                        <input type="number" name="addLoanAmount1" class="form-control">
                      </div>
                    </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addLoanTermType1" class="form-control-label">Term Type: 
                       </label>
                          <select class="form-control" id="addLoanTermType1" name="addLoanTermType1">
                            <option value="1">-By Month (Default)-</option>
                            <option value="2">By Give</option>
                          </select>
                       </div>
                       <div class="form-group col">
                        <label for="addBorrowerTerm1" class="form-control-label">Term: 
                       </label>
                               
                         <input type="number" class="form-control" id="addBorrowerTerm1" name="     addBorrowerTerm1">
                       </div>
                       <div class="form-group col">
                         <label for="addBorrowerPercentage1" class="form-control-label">Percentage:</label>
                         <input type="number" class="form-control" id="addBorrowerPercentage1" name="       addBorrowerPercentage1">
                       </div>
                    </div>
                </form>      
            </div>
            <div class="tab-pane fade" id="existing" role="tabpanel">
                <form id="addLoanRecordForm2" style="padding-top: 1em;">
                    {{ csrf_field() }}
                  <div class="form-group">
                    <label for="addBorrowerCompany2" class="form-control-label">Borrower Company:</label>
                    <select class="form-control" id="addBorrowerCompany2" name="addBorrowerCompany2">
                      <option value="1">-No Company (Default)-</option>
        
                      @foreach ($companies as $company)
                        @if ($company->id != 1)
                          <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endif
                      @endforeach

                    </select>
                  </div>
                  <div class="form-group" style="margin-top: -5px;">
                    <label for="addBorrowerName2" class="form-control-label">Borrower Name:</label>
                    <select class="form-control" id="addBorrowerName2" name="addBorrowerName2">
                    </select>
                  </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addBorrowerDate2" class="form-control-label">Date of Loan:</label>
                        <input name="addBorrowerDate2" id="addBorrowerDate2" class="form-control    datepicker" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" data-date-format= "yyyy-mm-dd">
                      </div>
                      <div class="form-group col">
                        <label for="addLoanAmount2" class="form-control-label">Loan Amount:</label>
                        <input type="number" name="addLoanAmount2" class="form-control">
                      </div>
                    </div>
                  <div class="row">
                      <div class="form-group col">
                        <label for="addLoanTermType2" class="form-control-label">Term Type: 
                       </label>
                          <select class="form-control" id="addLoanTermType2" name="addLoanTermType2">
                            <option value="1">-By Month (Default)-</option>
                            <option value="2">By Give</option>
                          </select>
                       </div>
                      <div class="form-group col">
                         <label for="addBorrowerTerm2" class="form-control-label">Term:</label>
                         <input type="number" class="form-control" id="addBorrowerTerm2" name="     addBorrowerTerm2">
                       </div>
                       <div class="form-group col">
                         <label for="addBorrowerPercentage2" class="form-control-label">Percentage:</label>
                         <input type="number" class="form-control" id="addBorrowerPercentage2" name="addBorrowerPercentage2">
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