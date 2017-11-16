{{-- <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="{{ route('home') }}"><font color="yellow">JK Lending Management System</font></a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
        @if((set_active('loans/list/active') || set_active('loans/list/current') || set_active('loans/list/finished') == "active"))
          <li class="nav-item {{ set_active('loans/list/active') }}">
            <a class="nav-link" href="{{ route('home') }}">Active Remittable Loans</a>
          </li>
          <li class="nav-item {{ set_active('loans/list/current') }}">
            <a class="nav-link" href="{{ route('currentLoansList') }}">Current Loans</a>
          </li>
          <li class="nav-item {{ set_active('loans/list/finished') }}">
            <a class="nav-link" href="{{ route('finishedLoansList') }}">Finished Loans</a>
          </li>
        @endif
        </ul>
        <form class="form-inline mt-2 mt-md-0" method="POST" action="{{ route('logout') }}">
          {{ csrf_field() }}
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          <div class="dropdown">
            <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white">
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
                <button class="btn btn-link" type="submit">Logout</button>
            </div>
          </div>
        </form>
      </div>
    </nav>

  <div class="container-fluid">
      <div class="row">
    <nav class="col-xs-3 col-sm-3 col-md-2 col-lg-2 col-xl-2 d-none d-sm-block bg-light sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link {{ (set_active('loans/list/active') || set_active('loans/list/current') || set_active('loans/list/finished') == "active")? "active" : "" }}" href="{{ route('home') }}">Loans </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ set_active('cash_advances') }}" href="{{ route('cashAdvances') }}">Cash Advances</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ set_active('borrowers') }}" href="{{ route('borrowers') }}">Borrowers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ set_active('companies') }}" href="{{ route('companies') }}">Companies</a>
            </li>
          </ul>
          
        </nav> --}}

<!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center">
            <h2 class="h5 text-uppercase">{{ Auth::user()->name }}</h2><span class="text-uppercase">Admin</span>
          </div>
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>J</strong><strong class="text-primary">K</strong></a></div>
        </div>
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li class="{{ (set_active('loans/list/*') || set_active('loan/record/*') == "active")? "active" : "" }}"><a href="#loan-types" data-toggle="collapse" aria-expanded="false"><i class="fa fa-list-alt" aria-hidden="true"></i><span>Loans</span>
                <div class="arrow pull-right"><i class="fa fa-angle-down"></i></div></a>
                    <ul id="loan-types" class="collapse list-unstyled">
                        <li> <a href="{{ route('home') }}">Active</a></li>
                        <li> <a href="{{ route('currentLoansList') }}">Current</a></li>
                        <li> <a href="{{ route('finishedLoansList') }}">Finished</a></li>
                    </ul>
            </li>

            <li class="{{ set_active('cash_advances') }}"> <a href="{{ route('cashAdvances') }}"><i class="fa fa-money" aria-hidden="true"></i><span>Cash Advances</span></a></li>
            <li class="{{ (set_active('borrowers') || set_active('borrower/*/profile') || set_active('borrower/*/loans') == "active" ? "
            active" : "") }}"> <a href="{{ route('borrowers') }}"><i class="fa fa-user-circle-o" aria-hidden="true"></i><span>Borrowers</span></a></li>
            <li class="{{ (set_active('companies') || set_active('companies/*/*') == "active")? "active" : "" }}"> <a href="{{ route('companies') }}"><i class="fa fa-users" aria-hidden="true"></i><span>Companies</span></a></li>
            <li class="{{ set_active('') }}"> <a href="#"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Summary</span></a></li>
          </ul>
        </div>
      </div>
    </nav>