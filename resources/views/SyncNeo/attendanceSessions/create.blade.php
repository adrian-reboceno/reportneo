@extends('layouts.master')
@section('title', 'Neo Attendances sessions sync create')
@section('title-active', 'Cypherlearning Neo Attendances sessions sync')

@section('css-after')
<link href="{{ URL::asset('https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />


<link href="{{ URL::asset('https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/select/3.0.1/css/select.dataTables.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
<form method="POST" id="sync-form" action="{{ route('syncattendancesessions.store') }}" >
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
                    <div class="card-datatable table-responsive">
                        <input type="hidden" name="ids" id="selected-ids">
                        <table id="datatables" class="datatables-demo table table-striped table-bordered" role="grid" aria-describedby="report-table_info">
                            <thead>
                                <tr> 
                                    <th></th>                               
                                    <th>ID</th> 
                                    <th>LMS Class</th> 
                                    <th>Periodo</th>
                                    <th>CRN</th>
                                    <th>name</th>
                                    <th>Profesor</th>
                                    <th>Organizacion</th>                                   
                                </tr>
                            </thead>                       
                            <tbody>
                                @foreach ($NeoClasses as $NeoClass )                                   
                                    @php
                                        $parts = explode('-', $NeoClass->section_code);
                                    @endphp                                                                        
                                    <tr data-id="{{ $NeoClass->id }}">
                                        <td ></td>
                                        <td>{{$NeoClass->id}}</td>   
                                        <td>{{$NeoClass->lms_class}}</td>
                                        <td>{{ $parts[0] ?? '' }}</td>  
                                        <td>{{ $parts[1] ?? '' }}</td>  
                                        <td>{{$NeoClass->name}}</td> 
                                        <td>                                         
                                            @foreach ($NeoClass->teachers as $teacher)
                                                {{ $teacher->neoPerson?->first_name }} {{ $teacher->neoPerson?->last_name }} <br>                                            
                                            @endforeach                                      
                                        </td>
                                        <td>
                                            {{ $NeoClass->organization->name_organization }}
                                        </td>
                                    </tr>    
                                @endforeach     
                            </tbody>
                        </table>                                           
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
<script src="{{ URL::asset('https://code.jquery.com/jquery-3.7.1.js') }}" "></script>
{{-- <script src="{{ URL::asset('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script> --}}


<script src="{{ URL::asset('https://cdn.datatables.net/2.3.1/js/dataTables.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/select/3.0.1/js/dataTables.select.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/select/3.0.1/js/select.dataTables.js') }}"></script>


{{-- <script src="{{ URL::asset('https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script> --}}

<script src="{{ URL::asset('assets/js/pages/datatables/advance.init.js') }}"></script>
@endsection
@section('script-bottom')

<script>
document.getElementById('confirm-sync').addEventListener('click', function () {
    const table = $('#datatables').DataTable();
    const selectedRows = table.rows({ selected: true }).nodes(); // ← selecciona los nodos HTML
    const ids = Array.from(selectedRows).map(row => row.dataset.id); // ← accede a data-id

    if (ids.length === 0) {
        Swal.fire('Nada seleccionado', 'Selecciona al menos una fila.', 'warning');
        return;
    }
    console.log('IDs seleccionados:', ids);

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esto sincronizará las Attendances class desde NeoAPI.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, sincronizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
         if (result.isConfirmed) {
            console.log(ids); // Depuración
            document.getElementById('selected-ids').value = ids; //JSON.stringify(ids);
            document.getElementById('sync-form').submit();
        }
    });
});
</script>
@endsection