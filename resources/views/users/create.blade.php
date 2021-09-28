@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New User</h3>
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

      <form role="form" action="{{ route('users.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">User Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter User Name">
          </div>
          <div class="form-group">
            <label for="clientAddress">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
          </div>
          <div class="form-group">
            <label for="role">User Role</label>
            <input type="text" name="role" class="form-control" id="role" placeholder="Enter User Role">
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
