@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing {{ $user->name }}</h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="name">Username:</label>
            {{ $user->username }}
        </div>
        <div class="form-group">
          <label for="name">Name:</label>
            {{ $user->name }}
        </div>
        <div class="form-group">
          <label for="email">Email Address:</label>
            {{ $user->email }}
        </div>
        <div class="form-group">
            <strong>Roles:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                @endforeach
            @endif
        </div>
        <div class="form-group">
          <label for="role">Phone Number:</label>
            {{ $user->phone }}
        </div>
        <div class="form-group">
          <label for="role">Client Name:</label>
            {{ $user->client->clientName }}
        </div>
        <div class="form-group">
          <label for="notify">Low Bal. Notification: (KES)</label>
            @if ($user->notify == 1)
              Enabled
            @else
              Disabled
            @endif
        </div>
        <div class="form-group">
          <label for="threshold">Notify when bal. is below:</label>
            {{ $user->threshold }}
        </div>
        <div class="form-group">
          <label for="time">Notify daily at:</label>
            {{ $user->time }}
        </div>
        <div class="form-group">
          <label for="role">Timezone:</label>
            {{ $user->timezone }}
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('users.index') }}/{{ id($user->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
