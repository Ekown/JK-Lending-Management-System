<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lending Management System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Lending Management System created with Laravel 5.5 and Bootstrap 4 Beta">
    <meta name="author" content="Eron Tancioco">
    <meta name="robots" content="index, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Roboto Font CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">

    <!-- Twitter Bootstrap 4 Beta CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> --}}

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- DataTable Stylesheet -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.css') }}">

    <!-- DataTable Button Stylesheet -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables/Buttons-1.4.2/css/buttons.bootstrap4.min.css') }}">

    <!-- Bootstrap DatePicker 1.7.1 Stylesheet -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" />

    <!-- Selectize jQuery Select Boxes Replacement Stylesheet -->
  {{--   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.min.css" integrity="sha256-4BosA+P6Qycvyi2wsMf6zbq9Em7BJqMXk/SpXbQVJJY=" crossorigin="anonymous" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/selectize/css/selectize.min.css') }}" />

    <!-- jQuery 2.2.4 Script --> 
    {{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">

    <!-- Custom icon font-->
    <link rel="stylesheet" href="{{ asset('css/fontastic.css') }}">

    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="{{ asset('plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">

    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ mix('css/style.green.css') }}" id="theme-stylesheet">

    <!-- Custom stylesheet - for your changes-->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div id="loader-wrapper">
        <div id="loader"></div>
    </div>

    @if(Auth::check())
        @include ('layouts.navbar')

    <div class="page home-page">
        
        <!-- navbar-->
        <header class="header">
            <nav class="navbar">
              <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                  <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="{{ route('home') }}" class="navbar-brand">
                      <div class="brand-text d-none d-md-inline-block"><span><strong>J</strong><strong class="text-primary">K&nbsp;</strong></span>Lending Management System</div></a></div>
                  <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                    <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning">12</span></a>
                      <ul aria-labelledby="notifications" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item"> 
                            <div class="notification d-flex justify-content-between">
                              <div class="notification-content"><i class="fa fa-envelope"></i>You have 6 new messages </div>
                              <div class="notification-time"><small>4 minutes ago</small></div>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item"> 
                            <div class="notification d-flex justify-content-between">
                              <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                              <div class="notification-time"><small>4 minutes ago</small></div>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item"> 
                            <div class="notification d-flex justify-content-between">
                              <div class="notification-content"><i class="fa fa-upload"></i>Server Rebooted</div>
                              <div class="notification-time"><small>4 minutes ago</small></div>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item"> 
                            <div class="notification d-flex justify-content-between">
                              <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                              <div class="notification-time"><small>10 minutes ago</small></div>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge badge-info">10</span></a>
                      <ul aria-labelledby="notifications" class="dropdown-menu">
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            
                            <div class="msg-body">
                              <h3 class="h5">Jason Doe</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            
                            <div class="msg-body">
                              <h3 class="h5">Frank Williams</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                            
                            <div class="msg-body">
                              <h3 class="h5">Ashley Wood</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                            </div></a></li>
                        <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-envelope"></i>Read all messages    </strong></a></li>
                      </ul>
                    </li>
                    <form method="post" action="{{ route('logout') }}">
                    {{ csrf_field() }}
                    <li class="nav-item">
                        <button style="color: white; background-color: transparent; background-repeat:no-repeat; border: none; overflow: hidden; outline:none; font-size: smaller;" class="nav-link logout">Logout&nbsp;<i class="fa fa-sign-out"></i></button>
                    </li>
                    </form>
                  </ul>
                </div>
              </div>
            </nav>
        </header>
        

        @yield ('content')

        @include ('layouts.footer')
    </div>
    @else
        <div class="main-wrapper">
            @yield('content')

            
          @include ('layouts.footer')
        </div>
    @endif
    {{-- <div id="main-wrapper">
        @if (Auth::check())
            @include ('layouts.navbar')

            <main class="col-xs-9 col-sm-9 col-md-10 col-lg-10 col-xl-10 ml-sm-auto ml-xl-auto pt-2" role="main">
        @endif
        
        @yield ('content')

        @if (Auth::check())
            </main>
        @endif  
    </div> --}}
    
    
</body>
</html>