@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Credit Allocation</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('allocations.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing {{ $allocation->client->clientName }} Balance</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client_id">Client Name:</label>
            {{ $allocation->client->clientName }}
        </div>
        <div class="form-group">
          <label for="accBalance">Balance:</label>
            {{ $allocation->accBalance }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('allocations.index') }}/{{ id($allocation->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
