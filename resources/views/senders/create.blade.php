@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Sender ID</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('senders.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Sender ID</h3>
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

      <form role="form" action="{{ route('senders.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="name">Enter New Sender ID</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Sender ID">
          </div>
          (or select existing sender id below)
          <div class="form-group">
            <label for="existing_sender_ID">Select Existing Sender ID</label>
            <select class="form-control select2" style="width: 100%;" name="existing_sender_ID", id="existing_sender_ID">
              <option></option>
              @foreach ($senders as $cl)
              <option value="{{$cl->id}}" >{{ $cl->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="client_name_id">Select Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client_name_id", id="client_name_id">
              <option></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" >{{ $cl->clientName }}</option>
              @endforeach
            </select>
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
