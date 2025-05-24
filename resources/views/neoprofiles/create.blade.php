@extends('layouts.master')
@section('title', 'Role create')
@section('title-active', 'Manager Role')

@section('css')

@endsection


@section('content')
<div class="row justify-content-center">
   {{--  <div class="row"> --}}
        <div class="card mb-4">
            <div class="card-header align-items-center ">
                <h4 class="card-title mb-0">Create role</h4>                
            </div><!-- end card header -->
            <div class="card-body ">
                <form method="POST" action="{{ route('neoprofiles.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="ProfileName" class="form-label">Profile name</label>
                                <input type="text" class="form-control" name="ProfileName" id="ProfileName" placeholder="Enter profile name" value="{{ old('ProfileName') }}">
                                @error('ProfileName')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->                                                
                    </div>
                    
                    <div class="row">                        
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>                           
                        </div><!--end col-->
                    </div>
                </form>
                
            </div>                          
        </div>
   {{--  </div> --}}
    <!--end col-->
</div>
@endsection
@section('script')

@endsection