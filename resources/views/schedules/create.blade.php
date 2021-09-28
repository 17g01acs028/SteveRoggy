@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Schedule</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('schedules.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Schedule</h3>
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

      <form role="form" action="{{ route('schedules.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="contact_id">Phone Number</label>
            <input type="text" name="contact_id" class="form-control" id="contact_id" placeholder="Enter Price per SMS">
          </div>
          <div class="form-group">
            <label for="group_id">Group</label>
            <input type="text" name="group_id" class="form-control" id="group_id" placeholder="Enter Price per SMS">
          </div>
          <div class="form-group">
            <label for="source">Source</label>
            <input type="text" name="source" class="form-control" id="source" placeholder="Enter Source">
          </div>
          <div class="form-group">
            <label for="text">Message</label>
            <input type="text" name="text" class="form-control" id="text" placeholder="Enter Message">
          </div>
          <div class="form-group">
            <label for="send_time">Time</label>
            <input type="text" name="send_time" class="form-control" id="send_time" placeholder="Enter Send Time">
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
