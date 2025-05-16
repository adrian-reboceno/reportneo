@extends('layouts.master')
@section('title', ' Neo Api list')
@section('title-active', 'Cypherlearning Neo Api')

@section('css-after')
<link href="{{ URL::asset('https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">            
            <div class="card-header">
                <h5>Status List </h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center m-l-0">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6 text-right">
                        @can('neoapi-create')  
                            <a class="btn btn-success btn-sm mb-3 btn-round" href="{{route('neoapis.create')}}"><i class="feather icon-plus"></i> Add Neo Api</a>
                        @endcan
                    </div>
                </div>
                <div >
                    <table id="datatables" class="datatables-demo table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="report-table_info" style="width:100%">
                        <thead>
                            <tr>                                
                                <th>ID</th>        
                                <th>Id portal</th>                   
                                <th>School name</th>
                                <th>hostapi</th>
                                <th>apikey</th>
                                <th>version</th>
                                <th>Status</th>                                
                                <th>Create Date</th>   
                                <th>Update Date</th>                                                                  
                                <th>Action</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            @foreach ($neoApis as $neoApi )                                                                          
                            <tr>
                                <td>{{$neoApi->id}}</td> 
                                <td>{{$neoApi->neoTenant->idportal}}</td>                                                   
                                <td>{{$neoApi->neoTenant->school_name}}</td> 
                                <td>{{$neoApi->hostapi}}</td>   
                                <td>{{$neoApi->apikey}}</td>
                                <td>{{$neoApi->version}}</td>
                                <td><span class="badge  badge-{{$neoApi->status ? $neoApi->status->status_color : ''}} ">{{$neoApi->status ? $neoApi->status->status_name : ''}}</span> </td>                               
                                <td>{{$neoApi->created_at}}</td>   
                                <td>{{$neoApi->updated_at}}</td>                       
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Acction</button>
                                        <div class="dropdown-menu">
                                            @can('neoapi-show')  
                                                <li><a href="{{ route('neoapis.show', $neoApi->id)}}" class="dropdown-item"><i class="bi bi-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                            @endcan
                                            @can('neoapi-edit')  
                                                <li><a href="{{ route('neoapis.edit', $neoApi->id)}}" class="dropdown-item edit-item-btn"><i class="bi bi-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                            @endcan
                                            @can('neoapi-delete')  
                                                <li>                                               
                                                    <form action="{{ route('neoapis.destroy', $neoApi->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link link-underline link-underline-opacity-0 text-danger"><i class="bi bi-trash-fill align-bottom me-2 text-muted"></i> Delete</button>
                                                    </form>    
                                                </li>
                                            @endcan
                                        </div>
                                    </div>                                                  
                                </td>
                            </tr>    
                            @endforeach     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script-page')
<script src="{{ URL::asset('https://code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables/basic.init.js') }}"></script>
@endsection