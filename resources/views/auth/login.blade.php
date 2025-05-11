@extends('layouts.authentication')
@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form action="{{ route('login') }}" method="POST" class="card auth_form">
            @csrf
            <div class="header">
                
                <img class="logo" src="{{ URL::asset('assets/images/logo.svg')}}" alt="">
                <h5>Log in</h5>
            </div>
            <div class="body">
                <div class="input-group mb-3">
                    {{-- <input type="text" class="form-control" placeholder="Username"> --}}
                    <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="username" name="email" placeholder="Enter username">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    {{-- <input type="text" class="form-control" placeholder="Password"> --}}
                    <input type="password" class="form-control password-input pe-5 @error('password') is-invalid @enderror" name="password" placeholder="Enter password" id="password-input" >
                    <div class="input-group-append">                                
                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                    </div>   
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror                         
                </div>
                <div class="checkbox">
                    <input id="remember_me" type="checkbox">
                    <label for="remember_me">Remember Me</label>
                </div>              
                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Sign In</button>                                 
            </div>
        </form>
        <div class="copyright text-center">
            &copy;
            <script>document.write(new Date().getFullYear())</script>,
            <span>Designed by <a href="https://www.talisis.com/" target="_blank">OnLine</a></span>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12">
        <div class="card">
            <img src="{{ URL::asset('assets/images/signin.svg')}}" alt="Sign In"/>
        </div>
    </div>
</div>
@endsection