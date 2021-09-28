@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Client</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('clients.index') }}"> Back</a>
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Client</h3>
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

    <form action="{{ route('clients.update',$client->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="clientName">Client Name</label>
            <input type="text" name="clientName" class="form-control" id="clientName" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="clientAddress">Address</label>
            <input type="text" name="clientAddress" class="form-control" id="clientAddress" placeholder="Client's Address">
          </div>
          <div class="form-group">
            <label for="mobileNo">Mobile Number</label>
            <input type="text" name="mobileNo" class="form-control" id="mobileNo" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="accType">Account Type</label>
            <input type="text" name="accType" class="form-control" id="accType" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="accBalance">Account Balance</label>
            <input type="text" name="accBalance" class="form-control" id="accBalance" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="accStatus">Account Status</label>
            <input type="text" name="accStatus" class="form-control" id="accStatus" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="httpDlrUrl">Dlr Report Url</label>
            <input type="text" name="httpDlrUrl" class="form-control" id="httpDlrUrl" placeholder="Enter Client Name">
          </div>
          <div class="form-group">
            <label for="dlrHttpMethod">HTTP Method</label>
            <input type="text" name="dlrHttpMethod" class="form-control" id="dlrHttpMethod" placeholder="Enter Client Name">
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
