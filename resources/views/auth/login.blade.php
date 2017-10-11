@extends ('layouts.master')

@section ('content')

    <div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-5" style="font-family: 'Raleway'; color: white;">Lending Management System</h2>
            <br>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <span class="anchor" id="formLogin"></span>

                    <!-- form card login -->
                    <div class="card bg-secondary" id="loginForm">
                        <div class="card-header" id="loginFormHead">
                            <h3 class="mb-0">Login</h3>
                        </div>
                        <div class="card-body" id="loginFormBody">
                            <form class="form" role="form" autocomplete="off" id="formLogin" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                    <span class="help-block" style="color: red">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                    required="" autocomplete="new-password">
                                </div>
                                <div class="form-check small">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" {{ old('remember') ? 'checked' : '' }} name="remember"> <span>Remember me on this computer</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right">Login</button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>

                                <a class="btn btn-link" href="{{ route('register') }}">
                                    Create New Account?
                                </a>
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