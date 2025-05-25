@extends('layouts.master')
@section('title', 'Neo Class sync create')
@section('title-active', 'Cypherlearning Neo Class sync')

@section('css-after')

@endsection


@section('content')
<form method="POST" id="sync-form" action="{{ route('syncclasses.store') }}" >
    @csrf
    <div class="nav-tabs-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#user-edit-account">Neo Sync</a>
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
                                    <option value="">-- Selecciona un Tenant --</option>
                                    @foreach ( $neoTenants as $neoTenant)
                                        <option value="{{ $neoTenant->id }}" >{{ $neoTenant->school_name }}</option>
                                    @endforeach 
                                </select>
                                @error('neo_tenant_id')                                           
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>    
                        <div class="col-lg-3">
                            <div class="mb-3">
                                <label for="organization_id" class="form-label">Neo Organizations</label>                                                                        
                                <select name="organization_id" id="organization_id" class="custom-select form-control" s style="width: 100%" data-allow-clear="true">                                  
                                </select>
                                @error('organization_id')                                           
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
@endsection
@section('script-page')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('script-bottom')
<script>
    $(document).ready(function () {
        $('#neo_tenant_id').on('change', function () {
            var tenantId = $(this).val();
            $('#organization_id').html('<option value="">Cargando...</option>');

            if (tenantId) {
                $.ajax({
                    url: '../organizations-by-tenant/' + tenantId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#organization_id').empty();
                        $('#organization_id').append('<option value="">-- Selecciona una Organización --</option>');

                        $.each(data, function (parentId, group) {
                            if (parentId === "null" || parentId === null) {
                                // Organizaciones sin padre
                                $.each(group, function (index, org) {
                                    $('#organization_id').append('<option value="' + org.id + '">' + org.name_organization + '</option>');
                                });
                            } else {
                                // Agrupar bajo el nombre del padre
                                let parentName = group[0].parent?.name_organization || "Grupo " + parentId;
                                let optgroup = $('<optgroup>').attr('label', parentName);

                                $.each(group, function (index, org) {
                                    optgroup.append('<option value="' + org.id + '">' + org.name_organization + '</option>');
                                });

                                $('#organization_id').append(optgroup);
                            }
                        });
                    }
                });
            } else {
                $('#organization_id').html('<option value="">-- Selecciona una Organización --</option>');
            }
        });
    });
</script>
<script>
document.getElementById('confirm-sync').addEventListener('click', function () {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esto sincronizará las class desde NeoAPI.",
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