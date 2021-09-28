@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Prefix Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('prefixes.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing prefix {{ $prefix->prefix }} Details</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="network_id">Network Name:</label>
            {{ $prefix->network->name }}
        </div>
        <div class="form-group">
          <label for="prefix">Prefix:</label>
            {{ $prefix->prefix }}
        </div>
        <div class="form-group">
          <label for="prefix_length">Prefix Length:</label>
            {{ $prefix->prefix_length }}
        </div>
        <div class="form-group">
          <label for="number_length">Number Length:</label>
            {{ $prefix->number_length }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('prefixes.index') }}/{{ id($prefix->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
