@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Client-Route Mapping Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('route_maps.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing {{ $routeMap->client->clientName }} route map details</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client_id">Client Name:</label>
            {{ $routeMap->client->clientName }}
        </div>
        <div class="form-group">
          <label for="network_id">Network Name:</label>
            {{ $routeMap->network->name }}
        </div>
        <div class="form-group">
          <label for="route_id">Route Name:</label>
            {{ $routeMap->route->name }}
        </div>
        <div class="form-group">
          <label for="user_id">Traffic User:</label>
          @if(!empty($routeMap->user->username))
          {{ $routeMap->user->username }}
          @endif
        </div>
        <div class="form-group">
          <label for="price">Price per SMS:</label>
            {{ $routeMap->price }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('route_maps.index') }}/{{ id($routeMap->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
