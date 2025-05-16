@extends('layouts.master')
@section('title', 'Neo Tenant show')
@section('title-active', 'Cypherlearning Neo Tenant')

@section('css-after')

@endsection


@section('content')

<div class="media align-items-center py-3 mb-3">
    
    <div class="media-body ml-4">
        <h4 class="font-weight-bold mb-0">{{$neotenant->school_name}}</h4>
        <div class="text-muted mb-2">Id Portal: {{$neotenant->idportal}}</div>
        {{-- <a href="javascript:void(0)" class="btn btn-primary btn-sm">Edit</a>&nbsp;
        <a href="javascript:void(0)" class="btn btn-default btn-sm">Profile</a>&nbsp;
        <a href="javascript:void(0)" class="btn btn-default btn-sm icon-btn">
            <i class="ion ion-md-mail"></i>
        </a> --}}
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <table class="table user-view-table m-0">
            <tbody>
                <tr>
                    <td>Url:</td>
                    <td>
                        {{$neotenant->url}}
                    </td>
                </tr>
                <tr>
                    <td>private key:</td>
                    <td>{{$neotenant->privatekey}}</td>
                </tr>
                <tr>
                    <td>Create at:</td>
                    <td>{{$neotenant->created_at}}</td>
                </tr>
                <tr>
                    <td>Update at:</td>
                    <td>
                        {{$neotenant->updated_at}}
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <span class="badge  badge-{{$neotenant->status ? $neotenant->status->status_color : ''}} ">{{$neotenant->status ? $neotenant->status->status_name : ''}}</span>
                    </td>
                </tr>               
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script-page')

@endsection