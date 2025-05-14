@extends('layouts.master')
@section('title', 'status create')
@section('title-active', 'Catalog status')

@section('css')

@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Create status</h4>                
            </div><!-- end card header -->
            <div class="card-body p-4">
                <form method="POST" action="{{ route('status.update', $status->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status_name" class="form-label">Status name</label>
                                <input type="text" class="form-control" name="status_name" id="status_name" placeholder="Enter status name" value="{{ $status->status_name }}">
                                @error('status_name')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description">{{$status->description}}</textarea>
                                @error('description')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status_color" class="form-label">Color</label>
                                <select class="custom-select" name="status_color" id="status_color">                                  
                                    <option value="success" @if($status->status_color == 'success') selected @endif>Success</option>
                                    <option value="primary" @if($status->status_color == 'primary') selected @endif>Primary</option>
                                    <option value="warning" @if($status->status_color == 'warning') selected @endif>Warning</option>
                                    <option value="danger" @if($status->status_color == 'danger') selected @endif>Danger</option>
                                    <option value="secondary" @if($status->status_color == 'secondary') selected @endif>Secondary </option>                                   
                                </select>                              
                                @error('status_color')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->                       
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">actualizar</button>
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