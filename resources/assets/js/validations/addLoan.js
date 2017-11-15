

// Validates the add loan modal form based on the given form
function addLoanValidate(form)
{
	// If the given form is for new borrowers
	if(form == 'addLoanRecordForm1')
	{
		var valid = true;

		var ifExists = function() {
			var temp = null;

			$.ajax({
				global: false,
				async: false,
				data : { 
					name: $('#addBorrowerName1').val(), 
					company: $('#addBorrowerCompany1').val() 
				},
				url: "http://jklending.prod:81/add/loan/check/borrower",
				method: "POST",
				success: function(data) {
					//console.log("This is the ajax success: " + ifExists);
					temp = data;
				},
				error: function(res) {
					console.log("An error occured");
				}
			});

			return temp;
		}();

		//console.log("this is the variable: " + ifExists);

		// If the borrower name is empty, has a number or already existing, 
		// add an error message to it
		if($('#addBorrowerName1').val() == "" || (/[0-9 -()+]+$/.test($('#addBorrowerName1').val()) != false)
			|| ifExists == true)
		{
			$('#addBorrowerName1').addClass("is-invalid");
			//console.log("name: " + $('#addBorrowerName1').val() + " , company:" + $('#addBorrowerCompany1').val())

			// If the borrower already exists
			if(ifExists == true)
			{
				//console.log("write the error for existing");
				$('#name-error-msg').html("Borrower already exists, try the existing borrower tab");
			}

			valid = false;		
		}
		else if($('#addBorrowerName1').val() != "" && (/[0-9 -()+]+$/.test($('#addBorrowerName1').val()) == false))
		{
			$('#addBorrowerName1').removeClass("is-invalid");
		}

		// If the loan amount field is blank, less than 0 or greater than 10 million, 
		// add an error message
		if ($('#addLoanAmount1').val() == "" || $('#addLoanAmount1').val() <= 0 || $('#addLoanAmount1').val() > 10000000)
		{
			$('#addLoanAmount1').addClass("is-invalid");

			valid = false;
		}
		else if($('#addLoanAmount1').val() != "" && $('#addLoanAmount1').val() > 0 
			&& $('#addLoanAmount1').val() <= 10000000)
		{
			$('#addLoanAmount1').removeClass("is-invalid");
		}

		// If the loan percentage is empty, less than or equal to zero, or greater than 100,
		// add an error message
		if ($('#addBorrowerPercentage1').val() == "" || $('#addBorrowerPercentage1').val() <= 0 
			|| $('#addBorrowerPercentage1').val() > 100)
		{
			$('#addBorrowerPercentage1').addClass("is-invalid");

			valid = false;
		}
		else if($('#addBorrowerPercentage1').val() != "" && $('#addBorrowerPercentage1').val() > 0 
			&& $('#addBorrowerPercentage1').val() <= 100)
		{
			$('#addBorrowerPercentage1').removeClass("is-invalid");
		}

		// If the loan term is empty, less than or equal to zero or greater than 99.5
		// add an error message
		if ($('#addBorrowerTerm1').val() == "" || $('#addBorrowerTerm1').val() <= 0 
			|| $('#addBorrowerTerm1').val() > 99.5)
		{
			$('#addBorrowerTerm1').addClass("is-invalid");
			
			valid = false;
		}
		else if($('#addBorrowerTerm1').val() != "" && $('#addBorrowerTerm1').val() > 0 
			&& $('#addBorrowerTerm1').val() <= 99.5)
		{
			$('#addBorrowerTerm1').removeClass("is-invalid");
		}

		return valid;
	}	
	// If the given form is for old borrowers
	else
	{
		var valid = true;

		// If the loan amount field is blank, less than 0 or greater than 10 million, 
		// add an error message
		if ($('#addLoanAmount2').val() == "" || $('#addLoanAmount2').val() <= 0 
			|| $('#addLoanAmount2').val() > 10000000)
		{
			$('#addLoanAmount2').addClass("is-invalid");

			valid = false;
		}
		else if($('#addLoanAmount2').val() != "" && $('#addLoanAmount2').val() > 0 
			&& $('#addLoanAmount2').val() <= 10000000)
		{
			$('#addLoanAmount2').removeClass("is-invalid");
		}

		// If the loan percentage is empty, less than or equal to zero, or greater than 100,
		// add an error message
		if ($('#addBorrowerPercentage2').val() == "" || $('#addBorrowerPercentage2').val() <= 0 
			|| $('#addBorrowerPercentage2').val() > 100)
		{
			$('#addBorrowerPercentage2').addClass("is-invalid");

			valid = false;
		}
		else if($('#addBorrowerPercentage2').val() != "" && $('#addBorrowerPercentage2').val() > 0 
			&& $('#addBorrowerPercentage2').val() <= 100)
		{
			$('#addBorrowerPercentage2').removeClass("is-invalid");
		}

		// If the loan term is empty, less than or equal to zero or greater than 99.5
		// add an error message
		if ($('#addBorrowerTerm2').val() == "" || $('#addBorrowerTerm2').val() <= 0 
			|| $('#addBorrowerTerm2').val() > 99.5)
		{
			$('#addBorrowerTerm2').addClass("is-invalid");
			
			valid = false;
		}
		else if($('#addBorrowerTerm2').val() != "" && $('#addBorrowerTerm2').val() > 0 
			&& $('#addBorrowerTerm2').val() <= 99.5)
		{
			$('#addBorrowerTerm2').removeClass("is-invalid");
		}

		return valid;
	}
}