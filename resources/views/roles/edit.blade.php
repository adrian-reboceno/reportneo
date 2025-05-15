@extends('layouts.master')
@section('title', 'Role Uopdate')
@section('title-active', 'Manager Role')

@section('css')

@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Update role</h4>                
            </div><!-- end card header -->
            <div class="card-body p-4">
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="roleName" class="form-label">Role name</label>
                                <input type="text" class="form-control" name="roleName" id="roleName" placeholder="Enter status name" value="{{ $role->name }}">
                                @error('roleName')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->                                                
                    </div>
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Permissions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">                                   
                                    @foreach($permissions as $permission)                                  
                                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                                        <label class="switcher switcher-success">                                           
                                            <input class="switcher-input" type="checkbox" role="success" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="permission-{{ $permission->id }}" name="permissions[{{$permission->name }}]">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes">
                                                    <span class="ion ion-md-checkmark"></span>
                                                </span>
                                                <span class="switcher-no">
                                                    <span class="ion ion-md-close"></span>
                                                </span>
                                            </span>
                                            <span class="switcher-label"  for="permission-{{ $permission->name }}"> {{ $permission->name }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="row">                        
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>                           
                        </div><!--end col-->
                    </div>
                </form>
                
            </div>                          
        </div>
    </div>
    <!--end col-->
</div>
@endsection
@section('script')

@endsection