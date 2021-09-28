@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Mpesa Code</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('mpesa_codes.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Code </h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client_id">Client Name:</label>
            {{ $mpesaCode->client->clientName }}
        </div>
        <div class="form-group">
          <label for="code">Code:</label>
            {{ $mpesaCode->code }}
        </div>
        <div class="form-group">
          <label for="created_at">Created at:</label>
            {{ $mpesaCode->created_at }}
        </div>
        <div class="form-group">
          <label for="updated_at">Updated at:</label>
            {{ $mpesaCode->updated_at }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
      </div>
    </div>
  </div>
</div>
@endsection
