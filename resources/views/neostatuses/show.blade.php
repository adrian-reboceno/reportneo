@extends('layouts.master')
@section('title', 'Neo status')
@section('title-active', 'Neo status')

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
                <h4 class="font-weight-bold mb-4">{{$neostatus->status_name}}</h4>
                <div class="text-muted mb-4">
                    {{--  Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro principes ei has. --}}
                </div>                
                <strong>Create Date:</strong>
                <span class="text-muted">{{$neostatus->created_at}}</span>                        
                <strong>Updated Date : </strong>
                <span class="text-muted">{{$neostatus->updated_at}}</span>            
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
                    <div class="col-md-3 text-muted">Summary:</div>
                    <div class="col-md-9">
                        {{$neostatus->description}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 text-muted">Create Date:</div>
                    <div class="col-md-9">
                        <span class="text-dark">{{$neostatus->created_at}}</span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 text-muted">Updated date:</div>
                    <div class="col-md-9">
                        <span class="text-dark">{{$neostatus->updated_at}}</span>
                    </div>
                </div>                             
            </div>            
        </div>
        <!-- / Info -->
    </div>
</div>
@endsection
@section('script-page')

@endsection