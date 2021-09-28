@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Client Route Mapping</h2>
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
        <h3 class="card-title">Map Client to Route</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
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

      <form role="form" action="{{ route('route_maps.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="client_id">Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id">
              <option>---Select Client---</option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="network_id">Network Name</label>
            <select class="form-control select2" style="width: 100%;" name="network_id", id="network_id">
              <option>---Select Network---</option>
              @foreach ($networks as $cl)
              <option value="{{$cl->id}}" >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="route_id">Route Name</label>
            <select class="form-control select2" style="width: 100%;" name="route_id", id="route_id">
              <option>---Select Route---</option>
              @foreach ($routes as $cl)
              <option value="{{$cl->id}}" >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="user_id">Traffic User</label>
            <select class="form-control select2" style="width: 100%;" name="user_id", id="user_id">
              <option></option>
              @foreach ($users as $cl)
              <option value="{{$cl->id}}" >{{ $cl->username }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="price">Price per SMS</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Enter Price per SMS">
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
