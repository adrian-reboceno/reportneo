@extends('layouts.master')
@section('title', 'Dashboard')
@section('parentPageTitle', 'Dashboard')
@section('css')

@endsection
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Title</h3>
      <div class="card-tools">
        <button
          type="button"
          class="btn btn-tool"
          data-lte-toggle="card-collapse"
          title="Collapse"
        >
          <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
          <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
        </button>
        <button
          type="button"
          class="btn btn-tool"
          data-lte-toggle="card-remove"
          title="Remove"
        >
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
    <div class="card-body">Start creating your amazing application!</div>
    <!-- /.card-body -->
    <div class="card-footer">Footer</div>
    <!-- /.card-footer-->
  </div>
@endsection
@section('script')
@endsection