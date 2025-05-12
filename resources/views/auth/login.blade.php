@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')
<div class="login-box">
    <div class="login-logo">
        <b>Admin</b>LTE
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="username" name="email" placeholder="Enter username">
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control password-input pe-5 @error('password') is-invalid @enderror" name="password" placeholder="Enter password" id="password-input" >
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <!--begin::Row-->
                <div class="row">
                    <div class="col-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                    </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </form>                        
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
@section('script')

@endsection
