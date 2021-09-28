@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Notification Message</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('notfis.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Notification Message </h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client_id">Client Name:</label>
            {{ $notfi->client->clientName }}
        </div>
        @role('super-admin|admin|manager')
        <div class="form-group">
          <label for="type">Message Type:</label>
            {{ $notfi->type }}
        </div>
        @endrole
        <div class="form-group">
          <label for="user_id">User Name:</label>
            {{ $notfi->user->username }}
        </div>
        <div class="form-group">
          <label for="sender">SenderId:</label>
            {{ $notfi->sender }}
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
            {{ $notfi->message }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('notfis.index') }}/{{ id($notfi->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
