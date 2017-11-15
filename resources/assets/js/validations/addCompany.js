
function addCompanyValidate()
{
	var valid = true;

	var ifExists = function() {
			var temp = null;

			$.ajax({
				global: false,
				async: false,
				data : { 
					name: $('#addCompanyFormName').val() 
				},
				url: "http://jklending.prod:81/add/company/check/company",
				method: "POST",
				success: function(data) {
					//console.log("This is the ajax success: " + data);
					temp = data;
				},
				error: function(res) {
					console.log("error");
				}
			});

			return temp;
		}();

	// If the company name field is empty
	if($('#addCompanyFormName').val() == "")
	{
		// Display error message
		$('#name-error-msg').html("Please enter a valid company name");
		$('#addCompanyFormName').addClass("is-invalid");

		valid = false;
	}

	if(ifExists == true) 
	{
		// Display error message
		$('#name-error-msg').html($('#addCompanyFormName').val() + " is already in the database. Please	use another name");
		$('#addCompanyFormName').addClass("is-invalid");

		valid = false;
	}

	return valid;
}