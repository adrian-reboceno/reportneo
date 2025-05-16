@extends('layouts.master')
@section('title', 'Neo Tenant update')
@section('title-active', 'Cypherlearning Neo Tenant')

@section('css-after')

@endsection


@section('content')
<form method="POST" action="{{ route('neotenants.update', $neotenant->id)}}"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="nav-tabs-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#user-edit-account">Neo Tenant</a>
            </li>
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="user-edit-account">                          
                <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Id portal</label>
                                <input type="number" class="form-control" id="idportal" name="idportal" placeholder="Enter id portal" value="{{$neotenant->idportal}}">
                                @error('idportal')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="school_name" class="form-label">School name</label>
                                <input type="text" class="form-control" id="school_name" name="school_name" placeholder="Enter school name" value="{{$neotenant->school_name}}">
                                @error('school_name')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="url" class="form-label">url</label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="Enter url" value="{{$neotenant->url}}">
                                @error('url')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="privatekey" class="form-label">Private key</label>
                                <input type="text" class="form-control" name="privatekey" id="privatekey" placeholder="Enter privatekey" value="{{$neotenant->privatekey}}">
                                @error('privatekey')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->                                             
                    </div>
                </div>                
                <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">                       
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label for="status_id" class="form-label">Status</label>                                                                        
                                <select name="status_id" id="status_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    @foreach ( $statuses as $status)
                                        <option value="{{ $status->id }}" {{$status->id ==  $neotenant->status_id ? 'selected' : ''}} >{{ $status->status_name }}</option>
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

@endsection