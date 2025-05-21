@extends('layouts.master')
@section('title', 'Neo organizations sync create')
@section('title-active', 'Cypherlearning Neo organizations sync')

@section('css-after')

@endsection


@section('content')
<form method="POST" id="sync-form" action="{{ route('syncorganizations.store') }}" >
    @csrf
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
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="neo_tenant_id" class="form-label">Neo Tenant</label>                                                                        
                                <select name="neo_tenant_id" id="neo_tenant_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">
                                    @foreach ( $neoTenants as $neoTenant)
                                        <option value="{{ $neoTenant->id }}" >{{ $neoTenant->school_name }}</option>
                                    @endforeach 
                                </select>
                                @error('neo_tenant_id')                                           
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
        <button type="button" class="btn btn-primary" id='confirm-sync' >Sync changes</button>
    </div>
</form>
{{-- Barra de progreso --}}
<div id="progress-container" class="mt-4 d-none">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
            id="progress-bar" role="progressbar" style="width: 0%">0%</div>
    </div>
</div>
@endsection
@section('script-page')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('script-bottom')
<script>
document.getElementById('confirm-sync').addEventListener('click', function () {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esto sincronizará las organizaciones desde NeoAPI.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, sincronizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('sync-form').submit();
        }
    });
});
</script>
@endsection