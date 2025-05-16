@extends('layouts.master')
@section('title', 'Neo api show')
@section('title-active', 'Cypherlearning Neo api')

@section('css-after')

@endsection


@section('content')

<div class="media align-items-center py-3 mb-3">
    
    <div class="media-body ml-4">
        <h4 class="font-weight-bold mb-0">{{$neoApi->neoTenant->school_name}}</h4>
        <div class="text-muted mb-2">Id Portal: {{$neoApi->neoTenant->idportal}}</div>
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
                    <td>hostapi:</td>
                    <td>
                        {{$neoApi->hostapi}}
                    </td>
                </tr>
                <tr>
                    <td>api key:</td>
                    <td>{{$neoApi->apikey}}</td>
                </tr>
                <tr>
                    <td>Version:</td>
                    <td>{{$neoApi->version}}</td>
                </tr>
                <tr>
                    <td>Create at:</td>
                    <td>{{$neoApi->created_at}}</td>
                </tr>
                <tr>
                    <td>Update at:</td>
                    <td>
                        {{$neoApi->updated_at}}
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <span class="badge  badge-{{$neoApi->status ? $neoApi->status->status_color : ''}} ">{{$neoApi->status ? $neoApi->status->status_name : ''}}</span>
                    </td>
                </tr>               
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script-page')

@endsection