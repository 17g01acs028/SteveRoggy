@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Short Code</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('shortcodes.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Short Code</h3>
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

      <form role="form" action="{{ route('shortcodes.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Enter New Short Code</label>
            <input type="text" name="short_code" class="form-control" id="short_code" placeholder="Enter Short Code">
          </div>
          <div class="form-group">
            <label for="client_name_id">Select Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client_id", id="client_id">
              <option></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
            <div class="form-group">
                <label for="name">Enter New Short Code Description</label>
                <input type="text" name="description" class="form-control" id="description" placeholder="Enter Short Code Description">
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
