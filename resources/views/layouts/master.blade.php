<!DOCTYPE html>
<html>
<head>
    <title>Lending Management System</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Roboto Font CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">

    <!-- Twitter Bootstrap 4 Beta CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- Font Awesome 4.7.0 CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- DataTable Stylesheet -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <!-- DataTable Button Stylesheet -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">

    <!-- Bootstrap DatePicker 1.7.1 Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" integrity="sha256-I4gvabvvRivuPAYFqevVhZl88+vNf2NksupoBxMQi04=" crossorigin="anonymous" />

    <!-- Selectize jQuery Select Boxes Replacement Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.min.css" integrity="sha256-4BosA+P6Qycvyi2wsMf6zbq9Em7BJqMXk/SpXbQVJJY=" crossorigin="anonymous" />

    <!-- jQuery 2.2.4 Script --> 
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main-wrapper">
        @if (Auth::check())
            @include ('layouts.navbar')

            <main class="col-sm-9 ml-sm-auto ml-xl-auto col-md-10 pt-2" role="main">
        @endif
        
        @yield ('content')

        @if (Auth::check())
            </main>
        @endif
    
        @include ('layouts.footer')
    </div>
    
</body>
</html>