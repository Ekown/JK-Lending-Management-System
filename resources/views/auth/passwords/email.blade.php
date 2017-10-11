@extends('layouts.master')

@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-5" style="font-family: 'Raleway'; color: white;">Lending Management System</h2>
            <br><br>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <span class="anchor" id="formLogin"></span>

                    <!-- form card login -->
                    <div class="card bg-secondary" id="resetPasswordForm">
                        <div class="card-header" id="resetPasswordHead">
                            <h3 class="mb-0">Reset Password</h3>
                        </div>
                        <div class="card-body" id="resetPasswordBody"> 

                             @if (session('status'))
                                 <div class="alert alert-success">
                                     {{ session('status') }}
                                 </div>
                             @endif
                            <form class="form" role="form" autocomplete="off" id="formLogin" method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Send Reset Password Email</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
@endsection

@push('scripts')
<script>
    $.backstretch("{{ asset('img/login-bg.jpg') }}");   
</script>
@endpush