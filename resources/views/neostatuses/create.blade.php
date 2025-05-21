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
                <form method="POST" action="{{ route('neostatuses.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_name" class="form-label">Status name</label>
                                <input type="text" class="form-control" name="status_name" id="status_name" placeholder="Enter status name" value="{{ old('status_name') }}">
                                @error('status_name')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description">{{old('description')}}</textarea>
                                @error('description')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status_color" class="form-label">Color</label>
                                <select class="custom-select form-control" name="status_color" id="status_color">                                  
                                    <option value="success">Success</option>
                                    <option value="primary" >Primary</option>
                                    <option value="warning" >Warning</option>
                                    <option value="danger">Danger</option>
                                    <option value="secondary" >Secondary </option>                                   
                                </select>                              
                                @error('status_color')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div><!--end col-->                       
                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Create</button>
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