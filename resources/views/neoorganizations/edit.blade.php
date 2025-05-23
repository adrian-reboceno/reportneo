@extends('layouts.master')
@section('title', 'Neo organizations update')
@section('title-active', 'Cypherlearning Neo organizations')

@section('css-after')

@endsection


@section('content')
<form method="POST" action="{{ route('neoorganizations.update', $neoOrganization->id) }}" >
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
                                <label for="neo_tenant_id" class="form-label">Neo Tenant</label>                                                                        
                                <select name="neo_tenant_id" id="neo_tenant_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    @foreach ( $neoTenants as $neoTenant)
                                        <option value="{{ $neoTenant->id }}" {{$neoTenant->id ==  $neoOrganization->neo_tenant_id ? 'selected' : ''}} >{{ $neoTenant->school_name }}</option>
                                    @endforeach 
                                </select>
                                @error('neo_tenant_id')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>                      
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="lms_organization" class="form-label">LMS Organization </label>
                                <input type="number" class="form-control" id="lms_organization" name="lms_organization" placeholder="Enter LMS Organization" value="{{$neoOrganization->lms_organization}}">
                                @error('lms_organization')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="name_organization" class="form-label">Name organization</label>
                                <input type="text" class="form-control" id="name_organization" name="name_organization" placeholder="Enter Name organization" value="{{$neoOrganization->name_organization}}">
                                @error('name_organization')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Organization</label>                                                                        
                                <select name="parent_id" id="parent_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    <option value="0">Select</option>
                                    @foreach ( $neoOrganizations as $data)                                        
                                        <option value="{{ $data->id }}" {{$data->lms_organization ==  $neoOrganization->parent_id ? 'selected' : ''}}>{{ $data->name_organization }}</option>
                                    @endforeach 
                                </select>
                                @error('parent_id')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>  
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="type_operation" class="form-label">Type </label>                                                                        
                                <select name="type_operation" id="type_operation" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    <option value="N/A" {{$neoOrganization->type ==  'N/A' ? 'selected' : ''}}>N/A</option>
                                    <option value="Operacion" {{$neoOrganization->type ==  'Operacion' ? 'selected' : ''}}>Operacion</option>
                                    <option value="SEP" {{$neoOrganization->type ==  'SEP' ? 'selected' : ''}}>SEP</option>
                                    <option value="Master" {{$neoOrganization->type ==  'Master' ? 'selected' : ''}}>Master</option>
                                    <option value="Proveedor" {{$neoOrganization->type ==  'Proveedor' ? 'selected' : ''}}>Proveedor</option>
                                </select>
                                @error('type_operation')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>  
                        <!--end col-->                                                              
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