@extends ('layouts.master')

@section ('content')

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
								<li class="clearfix list-group-item border-0"><strong>Name:</strong> {{ $profile->name }}</li>
								<li class="clearfix list-group-item border-0"><strong>Company:</strong> {{ $profile->company }}</li>
								<li class="clearfix list-group-item border-0"><strong>Address:</strong> {{ $profile->address }}</li>
								<li class="clearfix list-group-item border-0"><strong>Contact Details:</strong> {{ $profile->contact_details }}</li>
							</ul>
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

			changeNumbers();

		    Echo.private(`borrowerChannel.{{ $profile->id }}`)
		      	.listen('Remittance', (e) => {
		          	// console.log(e);
		        	changeNumbers();
		    })
		    	.listen('AddLoanRecord', (e) => {
		    		changeNumbers();
		    });  
		});
	</script>
@endpush