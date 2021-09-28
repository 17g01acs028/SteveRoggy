@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Transaction Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('transactions.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client">Client Name:</label>
            {{ $transaction->client->clientName }}
        </div>
        <div class="form-group">
          <label for="mpesa_code">Mpesa Code:</label>
            {{ $transaction->mpesa_code->code }}
        </div>
        <div class="form-group">
          <label for="MSISDN">Phone Number:</label>
            {{ $transaction->MSISDN }}
        </div>
        <div class="form-group">
          <label for="FirstName">First Name:</label>
            {{ $transaction->FirstName }}
        </div>
        <div class="form-group">
          <label for="MiddleName">Middle Name:</label>
            {{ $transaction->MiddleName }}
        </div>
        <div class="form-group">
          <label for="LastName">Last Name:</label>
            {{ $transaction->LastName }}
        </div>
        <div class="form-group">
          <label for="TransactionType">Transaction Type:</label>
            {{ $transaction->TransactionType }}
        </div>
        <div class="form-group">
          <label for="TransID">Trans ID:</label>
            {{ $transaction->TransID }}
        </div>
        <div class="form-group">
          <label for="TransTime">Trans Time:</label>
            {{ $transaction->TransTime }}
        </div>
        <div class="form-group">
          <label for="TransAmount">Trans Amount:</label>
            {{ $transaction->TransAmount }}
        </div>
        <div class="form-group">
          <label for="BusinessShortCode">Business ShortCode:</label>
            {{ $transaction->BusinessShortCode }}
        </div>
        <div class="form-group">
          <label for="BillRefNumber">BillRefNumber:</label>
            {{ $transaction->BillRefNumber }}
        </div>
        <div class="form-group">
          <label for="OrgAccountBalance">OrgAccountBalance:</label>
            {{ $transaction->OrgAccountBalance }}
        </div>
        <div class="form-group">
          <label for="status">Notification Status:</label>
            {{ $transaction->status }}
        </div>
        <div class="form-group">
          <label for="error_message">Error Message:</label>
            {{ $transaction->error_message }}
        </div>
        <div class="form-group">
          <label for="created_at">Created At:</label>
            {{ $transaction->created_at }}
        </div>
        <div class="form-group">
          <label for="updated_at">Updated At:</label>
            {{ $transaction->updated_at }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
      </div>
    </div>
  </div>
</div>
@endsection
