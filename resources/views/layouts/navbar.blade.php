<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="{{ route('home') }}">Lending Management System</a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
{{--           <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Help</a>
          </li> --}}
        </ul>
        <form class="form-inline mt-2 mt-md-0" method="POST" action="{{ route('logout') }}">
          {{ csrf_field() }}
          {{-- <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> --}}
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
    <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link {{ set_active('home') }}" href="{{ route('home') }}">Master List </a>
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
          
        </nav>