@extends('layouts.master')
@section('title', 'Neo Api update')
@section('title-active', 'Cypherlearning Neo Api')

@section('css-after')

@endsection


@section('content')
<form method="POST" action="{{ route('neoapis.update',  $neoApi->id) }}" >
    @csrf
    @method('PUT')
    <div class="nav-tabs-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#user-edit-account">Neo Api</a>
            </li>
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="user-edit-account">                          
                <hr class="border-light m-0">
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="neo_tenant_id" class="form-label">Status</label>                                                                        
                                <select name="neo_tenant_id" id="neo_tenant_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    @foreach ( $neoTenants as $neoTenant)
                                        <option value="{{ $neoTenant->id }}" {{$neoTenant->id ==  $neoApi->neo_tenant_id ? 'selected' : ''}} >{{ $neoTenant->school_name }}</option>
                                    @endforeach 
                                </select>
                                @error('neo_tenant_id')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                      
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="hostapi" class="form-label">Host api</label>
                                <input type="text" class="form-control" id="hostapi" name="hostapi" placeholder="Enter Host api" value="{{$neoApi->hostapi}}">
                                @error('hostapi')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="apikey" class="form-label">apikey</label>
                                <input type="text" class="form-control" id="apikey" name="apikey" placeholder="Enter apikey" value="{{$neoApi->apikey}}">
                                @error('apikey')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="version" class="form-label">Version</label>
                                <input type="text" class="form-control" name="version" id="version" placeholder="Enter version" value="{{$neoApi->version }}">
                                @error('version')                                           
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
                                        <option value="{{ $status->id }}" {{$status->id ==  $neoApi->status_id ? 'selected' : ''}} >{{ $status->status_name }}</option>
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