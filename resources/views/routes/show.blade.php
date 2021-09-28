@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Route</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('routes.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Route Details</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Route Name:</label>
            {{ $route->name }}
        </div>
        <div class="form-group">
          <label for="price">Price per SMS:</label>
            {{ $route->price }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('routes.index') }}/{{ id($route->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
