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

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Roboto Font CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">

    <!-- Twitter Bootstrap 4 Beta CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> --}}

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap-4-0-0-beta.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- DataTable Stylesheet -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">

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
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>

    <div id="main-wrapper">
        @if (Auth::check())
            @include ('layouts.navbar')

            <main class="col-xs-9 col-sm-9 col-md-10 col-lg-10 col-xl-10 ml-sm-auto ml-xl-auto pt-2" role="main">
        @endif
        
        @yield ('content')

        @if (Auth::check())
            </main>
        @endif
    
        @include ('layouts.footer')
    </div>
    
</body>
</html>