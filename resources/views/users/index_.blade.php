@extends('layouts.master')
@section('title', 'Users list')
@section('parentPageTitle', 'Manager Users')

@section('title', 'Users list')
@section('css')
<link href="{{ URL::asset('https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><strong>Basic</strong> Examples </h2>
                
            </div>
            <div class="card-body p-0">
                <div class="{ ">
                    <table id="datatables" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>                                
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Paternal surname </th>
                                <th>Maternal surname</th>
                                <th>Email</th>                            
                                <th>Create Date</th>
                                <th>Role</th>
                                <th>Status</th>                            
                                <th>Action</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            @foreach ($users as $user )                                                                          
                            <tr>
                                <td>{{$user->id}}</td>   
                                <td>                                                                       
                                    <img src=" @if($user->avatar != '') {{ asset('storage/'.$user->avatar) }} @else {{ asset('assets/img/avatar5.png') }} @endif" alt="" class="user-image rounded-circle shadow" style="width: 45px; height:45px;" >                                                                                
                                </td>                         
                                <td>{{$user->name}}</td>
                                <td>{{$user->paternal_surname}}</td>
                                <td>{{$user->maternal_surname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>   
                                <td>                               
                                    {{-- @foreach ($user->roles as $role)                                       
                                        <span class="badge bg-success">{{ $role->name }}</span>
                                    @endforeach    --}}                         
                                </td>                                                       
                                <td><span class="badge  bg-{{$user->status ? $user->status->status_color : ''}} ">{{$user->status ? $user->status->status_name : ''}}</span> </td>                           
                                <td>
                                    
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acction
                                        </a>                                    
                                        <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
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
@section('script')
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