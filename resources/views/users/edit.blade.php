@extends('layouts.master')
@section('title', 'User update')
@section('title-active', 'Manager User')

@section('css-after')
<link rel="stylesheet" href="{{ URL::asset('assets/css/pages/users.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/libs/select2/select2.css') }}">
@endsection


@section('content')
<form method="POST" action="{{ route('users.update', $user->id) }}"  enctype="multipart/form-data">
    @csrf                         
    @method('PUT')
    <div class="nav-tabs-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#user-edit-account">Account</a>
            </li>
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="user-edit-account">           
                <div class="card-body">
                    <div class="media align-items-center">
                        <img src="@if($user->avatar != '') {{ asset('storage/'.$user->avatar) }} @else {{ asset('assets/img/avatars/user-dummy-img.jpg') }} @endif" alt="" class="d-block ui-w-80">
                        <div class="media-body ml-3">
                            <label class="form-label d-block mb-2">Avatar</label>
                            <label class="btn btn-outline-primary btn-sm">
                                Change
                                <input type="file" name="avatar" id="avatar" class="user-edit-fileinput">
                            </label>&nbsp;
                            <button type="button" class="btn btn-default btn-sm md-btn-flat">Reset</button>
                        </div>
                    </div>
                </div>
                <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="{{$user->name}}">
                                @error('name')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="paternal_surname" class="form-label">Paternal surname</label>
                                <input type="text" class="form-control" id="paternal_surname" name="paternal_surname" placeholder="Enter your lastname" value="{{$user->paternal_surname }}">
                                @error('paternal_surname')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="maternal_surname" class="form-label">Maternal surname</label>
                                <input type="text" class="form-control" id="maternal_surname" name="maternal_surname" placeholder="Enter your lastname" value="{{$user->maternal_surname }}">
                                @error('maternal_surname')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" value="{{$user->email}}">
                                @error('email')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->                                             
                    </div>
                </div>
               {{--  <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                @error('password')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Password confirmation</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter your password confirmation" >
                                @error('password_confirmation')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div> --}}
                <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label for="roles" class="form-label">Role</label>                                                                          
                                <select class="select2-demo form-control" name="roles[]" multiple style="width: 100%">                                         
                                    @foreach ( $roles as $role)
                                        <option value="{{ $role->name }}" {{$user->hasRole($role->name) ? 'selected' : ''}} >{{ $role->name }}</option>
                                    @endforeach  
                                </select>
                                @error('roles')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label for="status_id" class="form-label">Status</label>                                                                        
                                <select name="status_id" id="status_id" class="custom-select form-control" style="width: 100%" data-allow-clear="true">
                                    @foreach ( $statuses as $status)
                                        <option value="{{ $status->id }}" {{$status->id ==  $user->status_id ? 'selected' : ''}} >{{ $status->status_name }}</option>
                                    @endforeach 
                                </select>
                                @error('status_id')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>                      
            </div>       
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
@endsection
@section('script-page')
<script src="{{ URL::asset('assets/libs/select2/select2.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/forms_select/select.js') }}"></script>
@endsection