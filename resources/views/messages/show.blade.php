@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Message Details</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('messages.index') }}"> Back</a>
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
          <label for="source">From:</label>
            {{ $message->source }}
        </div>
        <div class="form-group">
          <label for="dest">To:</label>
            {{ $message->dest }}
        </div>
        <div class="form-group">
          <label for="text">Message:</label>
            {{ $message->text }}
        </div>
        <div class="form-group">
          <label for="client_id">Client:</label>
            {{ $message->client->clientName }}
        </div>
        <div class="form-group">
          <label for="user_id">User:</label>
            {{ $message->user->username }}
        </div>
        <div class="form-group">
          <label for="status">Delivery Status:</label>
            {{ $message->status }}
        </div>
        <div class="form-group">
          <label for="cost">Cost:</label>
            {{ $message->cost }}
        </div>
        <div class="form-group">
          <label for="parts">Message Parts:</label>
            {{ $message->parts }}
        </div>
        <div class="form-group">
          <label for="msgid">Message Id:</label>
            {{ $message->msgid }}
        </div>
        <div class="form-group">
          <label for="msgid">Error Message:</label>
            {{ $message->error_message }}
        </div>
        <div class="form-group">
          <label for="created_at">Created At:</label>
            {{ $message->created_at }}
        </div>
        <div class="form-group">
          <label for="updated_at">Updated At:</label>
            {{ $message->updated_at }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
      </div>
    </div>
  </div>
</div>
@endsection
