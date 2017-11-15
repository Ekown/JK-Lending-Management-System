
function addBorrowerValidate() 
{
	var valid = true;

	var ifExists = function() {
			var temp = null;

			$.ajax({
				global: false,
				async: false,
				data : { 
					name: $('#addBorrowerFormName').val(), 
					company: $('#addBorrowerFormCompany').val() 
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

		// If the borrower name is empty, has a number or already existing, 
		// add an error message to it
		if($('#addBorrowerFormName').val() == "" || (/[0-9 -()+]+$/.test($('#addBorrowerFormName').val()) != false)
			|| ifExists == true)
		{
			$('#addBorrowerFormName').addClass("is-invalid");
			$('#name-error-msg').html("Please enter a valid borrower");

			// If the borrower already exists
			if(ifExists == true)
			{
				//console.log("write the error for existing");
				$('#name-error-msg').html("Borrower already exists, try the existing borrower tab");
			}

			valid = false;		
		}

		return valid;

}