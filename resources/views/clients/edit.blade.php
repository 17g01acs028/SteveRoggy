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
        <h3 class="card-title">Update Client Details</h3>
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
            <input type="text" name="clientName" class="form-control" id="clientName" placeholder="Enter Client Name"
            value = "{{ $client->clientName ? : old('clientName') }}">
          </div>
          <div class="form-group">
            <label for="clientAddress">Address</label>
            <input type="text" name="clientAddress" class="form-control" id="clientAddress" placeholder="Client's Address"
            value = "{{ $client->clientAddress ? : old('clientAddress') }}">
          </div>
          <div class="form-group">
            <label for="mobileNo">Mobile Number</label>
            <input type="text" name="mobileNo" class="form-control" id="mobileNo" placeholder="Enter Client Name"
            value = "{{ $client->mobileNo ? : old('mobileNo') }}">
          </div>
          <div class="form-group">
            <label for="company_email">Company Email</label>
            <input type="text" value="{{ $client->company_email ? : old('company_email') }}" name="company_email" class="form-control" id="company_email" placeholder="Enter Company Email">
          </div>
          <div class="form-group">
            <label for="accLimit">Account Limit</label>
            <input type="text" name="accLimit" class="form-control" id="accLimit" placeholder="Enter Account Limit"
            value = "{{ $client->accLimit ? : old('accLimit') }}">
          </div>
          <div class="form-group">
            <label for="accType">Account Type</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="accType" id="accType1" value="1"
                @if ($client->accType == 1 ) checked @endif >
              <label class="form-check-label" for="accType1">
                Pre-Paid
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="accType" id="accType2" value="0"
                @if ($client->accType == 0 ) checked @endif >
              <label class="form-check-label" for="accType2">
                Post-Paid
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="accBalance">Account Balance</label>
            <input readonly type="number" name="accBalance" class="form-control" id="accBalance" placeholder="Account Balance"
            value = "{{ $client->accBalance ? : old('accBalance') }}">
          </div>
          <div class="form-group">
            <label for="httpDlrUrl">Dlr Report Url</label>
            <input type="text" name="httpDlrUrl" class="form-control" id="httpDlrUrl" placeholder="Enter Client Name"
            value = "{{ $client->httpDlrUrl ? : old('httpDlrUrl') }}">
          </div>
          <div class="form-group">
            <label for="dlrHttpMethod">HTTP Method</label>
            <select class="form-control select2" style="width: 100%;" name="dlrHttpMethod", id="dlrHttpMethod">
              <option></option>
              @foreach ($dlrMethods as $cl)
              <option value="{{$cl}}" {{ $client->dlrHttpMethod ? 'selected' : old('dlrHttpMethod') }} >{{ $cl }}</option>
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
