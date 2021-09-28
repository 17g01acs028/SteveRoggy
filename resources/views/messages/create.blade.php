@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Send a Quick Message</h2>
        </div>
        <div class="pull-right">
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Send SMS</h3>
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

      <form role="form" action="{{ route('messages.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="source">From:</label>
            <input type="text" name="source" class="form-control" id="source" placeholder="Enter Source Address">
          </div>
          <div class="form-group">
            <label for="dest">Phone Number:</label>
            <input type="text" name="dest" class="form-control" id="dest" placeholder="Enter Mobile Number">
          </div>
          <div class="form-group">
            <label for="text">Message:</label>
            <textarea class="form-control" rows="3" name="text" id="text" placeholder="Enter Message ..."></textarea>
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
