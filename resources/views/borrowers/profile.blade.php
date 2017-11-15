@extends ('layouts.master')

@section ('content')

    <div id="flash-message" class="clearfix"></div>

	<section class="charts">
		<div class="container-fluid">
			<header>
				<h1 class="h1">Borrower Profile</h1>
			</header>

			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<ul class="list-group list-group-flush">
								<li class="clearfix list-group-item border-0"><strong>ID:</strong> <span id="id">{{ $profile->id }}</span></li>
								<li class="clearfix list-group-item border-0"><strong>Name:</strong> <span id="name"></span></li>
								<li class="clearfix list-group-item border-0"><strong>Company:</strong> <span id="company"></span> </li>
								<li class="clearfix list-group-item border-0"><strong>Address:</strong> <span id="address"></span> </li>
								<li class="clearfix list-group-item border-0"><strong>Contact Details:</strong> <span id="contact"></span> </li>
							</ul>
@include ('borrowers.editProfileModal')
							<div class="text-center">
								<button data-toggle="modal" data-target="#editProfileModal" href="#" class="btn btn-primary" >Edit Profile</button >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<section class="dashboard-counts">
					<div class="card">
						<div class="card-body">
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-6 col-sm-6 col-md-6">
										<div class="wrapper count-title d-flex">
							                <div class="icon"><i class="icon-check"></i></div>
							                <div class="name"><strong class="text-uppercase">Loans &nbsp;
							                <a href="{{ route('borrowerLoans', ['id' => $profile->id]) }}">
							                	<i class="fa fa-arrow-circle-o-right" aria-hidden="true" style="font-size: initial; cursor: pointer;"></i>
							                </a>
							                </strong><span id="loan_date"></span>
							                  <div class="count-number" id="loan"></div>
							                </div>
							             </div>
							        </div>
							        <div class="col-xl-6 col-sm-6 col-md-6">
										<div class="wrapper count-title d-flex">
							                <div class="icon"><i class="icon-bill"></i></div>
							                <div class="name"><strong class="text-uppercase">Loan Remittances</strong><span id="loan_date"></span></strong><span id="loan_remit_date"></span>
							                  <div class="count-number" id="loan_remit"></div>
							                </div>
							             </div>
							        </div>
							        <div class="col-xl-6 col-sm-6 col-md-6">
										<div class="wrapper count-title d-flex">
							                <div class="icon"><i class="icon-list"></i></div>
							                <div class="name"><strong class="text-uppercase">Cash Advances &nbsp;
							                <a href="{{ route('borrowerCashAdvances', ['id' => $profile->id]) }}">
							                	<i class="fa fa-arrow-circle-o-right" aria-hidden="true" style="font-size: initial; cursor: pointer;"></i>
							                </a>
							            </strong><span id="loan_date"></span></strong><span id="cash_date"></span>
							                  <div class="count-number" id="cash"></div>
							                </div>
							             </div>
							        </div>
							        <div class="col-xl-6 col-sm-6 col-md-6">
										<div class="wrapper count-title d-flex">
							                <div class="icon"><i class="icon-list-1"></i></div>
							                <div class="name"><strong class="text-uppercase">Cash Advance Remittances</strong><span id="cash_remit_date"></span>
							                  <div class="count-number" id="cash_remit"></div>
							                </div>
							             </div>
							        </div>
							    </div>
						    </div>
						</div>
					</div>
					</section>
				</div>
			</div>
		</div>
	</section>	

@endsection


@push ('scripts')
	<script>
		$(document).ready(function (){
			function changeNumbers()
			{
				$.ajax({
					'async': true,
					'type': "POST",
					'global': false,
					'url': "/borrower/" + {{ $profile->id }} + "/profile/number/loans",
					'success': function(data)
					{
						// console.log(data);
						$('#loan').html(data[0]);
						$('#loan_remit').html(data[2]);

						if(data[0] != 0)
							$('#loan_date').html(data[1]);
						
						if(data[2] != 0)
							$('#loan_remit_date').html(data[3]);
					}
				});
			}

			function getProfileDetails()
			{
				$.ajax({
					'async': true,
					'type': "POST",
					'url': "{{ route('borrowerProfile', ['id' => $profile->id ]) }}",
					'success': function(data) {
					// Dynamic contect generation for the borrower profile
						$('#name').html(data[0].name);
						$('#company').html(data[0].company);
						$('#address').html(data[0].address);
						$('#contact').html(data[0].contact_details);

					// Dynamic contect generation for the edit profile modal
						$('#editBorrowerName').attr('value', data[0].name);
						$('#editBorrowerCompany').attr('value', data[0].company);
						$('#editBorrowerAddress').attr('value', data[0].address);
						$('#editBorrowerContact').attr('value', data[0].contact_details);

						console.log('Profile page updated.')
					},
					'error': function(res) {
						console.log('An error occurred.');
					}
				});
			}

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
		
			getProfileDetails();
			changeNumbers();

			$('#editButton').on('click', function() {
				$('#editProfileModal').modal('hide');

				$.ajax({
					'async': true,
					'type': "POST",
					'url': "{{ route('updateBorrowerProfile', ['id' => $profile->id ]) }}",
					'data': $('#editBorrowerProfileForm').serialize(),
					'success': function(data) {
						//console.log("Borrower #" + {{ $profile->id }} + "'s profile has been updated.");
					},
					'error': function(data) {
						console.log('There was an error encountered.');
					}
				});
			});

		    Echo.private(`borrowerChannel.{{ $profile->id }}`)
		      	.listen('Remittance', (e) => {
		          	// console.log(e);
		        	changeNumbers();
		        	alert("A loan remittance for <strong>" + $('#name').html() + "</strong> was made.")
		    })
		    	.listen('AddLoanRecord', (e) => {
		    		changeNumbers();
		    		alert("A new loan (" + e.loanId + ") for <strong>" + $('#name').html() + "</strong> was made.");
		    })
		    	.listen('EditProfile', (e) => {
		    		getProfileDetails();
		    		alert("The profile of <strong>" + $('#name').html() + "</strong> was updated."); 
		    });  
		});
	</script>
@endpush