@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Client's Route Map</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('route_maps.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Route Mapping</h3>
      </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('route_maps.update',$routeMap->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="client_id">Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id">
              <option value=""></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" {{ $routeMap->client_id == $cl->id ? 'selected' : old('client_id') }} >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="network_id">Network Name</label>
            <select class="form-control select2" style="width: 100%;" name="network_id", id="network_id">
              <option value=""></option>
              @foreach ($networks as $cl)
              <option value="{{$cl->id}}" {{ $routeMap->network_id == $cl->id ? 'selected' : old('network_id') }} >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="route_id">Route Name</label>
            <select class="form-control select2" style="width: 100%;" name="route_id", id="route_id">
              <option value=""></option>
              @foreach ($routes as $cl)
              <option value="{{$cl->id}}" {{ $routeMap->route_id == $cl->id ? 'selected' : old('route_id') }} >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="user_id">Traffic user</label>
            <select class="form-control select2" style="width: 100%;" name="user_id", id="user_id">
              <option value=""></option>
              @foreach ($users as $cl)
              <option value="{{$cl->id}}" {{ $routeMap->user_id == $cl->id ? 'selected' : old('user_id') }} >{{ $cl->username }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price per SMS</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Price per SMS"
            value = "{{ $routeMap->price ? : old('price') }}">
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.card -->
  </div>

</div>


@endsection
