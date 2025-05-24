@extends('layouts.master')
@section('title', 'Show role')
@section('title-active', 'Manager roles')

@section('css-after')

@endsection


@section('content')

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-auto col-sm-12">
                {{-- <img src="assets/img/avatars/5.png" alt class="d-block ui-w-100 rounded-circle mb-3"> --}}
            </div>
            <div class="col">
                <h4 class="font-weight-bold mb-4">{{$role->name}}</h4>
                <div class="text-muted mb-4">
                    {{--  Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro principes ei has. --}}
                </div>                
                <strong>Create Date:</strong>
                <span class="text-muted">{{$role->created_at}}</span>                        
                <strong>Updated Date : </strong>
                <span class="text-muted">{{$role->updated_at}}</span>            
            </div>
        </div>
    </div>
</div>
<!-- Header -->

<!-- end row -->
<div class="row">
    <div class="col">
        <!-- Info -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-2">
                    <h5 class="font-weight-bold mb-4">Permission:</h5>                   
                </div>
                <div class="row">                      
                    @foreach($role->permissions as $permission)                                 
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                        <label class="switcher switcher-success">                                           
                            <input class="switcher-input" type="checkbox" role="success" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="permission-{{ $permission->id }}" name="permissions[{{$permission->name }}]" disabled>
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
    </div>
        <!-- / Info -->
</div>

@endsection
@section('script-page')

@endsection