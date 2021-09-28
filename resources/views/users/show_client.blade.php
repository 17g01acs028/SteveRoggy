@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Account Details</h2>
            </div>
            <div class="pull-right">
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing {{ $client->clientName }} details</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="clientName">Client Name:</label>
            {{ $client->clientName }}
        </div>
        <div class="form-group">
          <label for="clientAddress">Address:</label>
            {{ $client->clientAddress }}
        </div>
        <div class="form-group">
          <label for="mobileNo">Mobile Number:</label>
            {{ $client->mobileNo }}
        </div>
        <div class="form-group">
          <label for="accLimit">Account Limit:</label>
            {{ $client->accLimit }}
        </div>
        <div class="form-group">
          <label for="accType">Account Type:</label>
            @if ($client->accType == 1)
              Pre-Paid
            @else
              Post-Paid
            @endif
        </div>
        <div class="form-group">
          <label for="accBalance">Account Balance:</label>
            {{ $client->accBalance }}
        </div>
        <div class="form-group">
          <label for="accStatus">Account Status:</label>
          @if ($client->accStatus == 1)
            Active
          @else
            Inactive
          @endif
        </div>
        <div class="form-group">
          <label for="httpDlrUrl">Dlr Report Url:</label>
            {{ $client->httpDlrUrl }}
        </div>
        <div class="form-group">
          <label for="dlrHttpMethod">HTTP Method:</label>
            {{ $client->dlrHttpMethod }}
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
      </div>
    </div>
  </div>
</div>
@endsection
