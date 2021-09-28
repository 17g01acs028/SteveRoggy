@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Profile</h2>
            </div>
            <div class="pull-right">
            </div>
        </div>
    </div>
<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Update Profile Details</h3>
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

    <form action="{{ route('update_user',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="form-group">
            <label for="username">Username</label>
            <input readonly type="text" name="username" class="form-control" id="username" placeholder="Enter Username"
            value = "{{ $user->username ? : old('username') }}">
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input readonly type="email" name="email" class="form-control" id="email" placeholder="Email Address"
            value = "{{ $user->email ? : old('email') }}">
          </div>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Full Name"
            value = "{{ $user->name ? : old('name') }}">
          </div>
          <div class="form-group">
            <label for="phone">Phone Number <small>(phone number should start with country code eg 254712345678)</small></label>
            <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number"
            value = "{{ $user->phone ? : old('phone') }}">
          </div>
          <div class="form-group">
            <label for="notify">Low Bal. Notification</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="notify" id="notify1" value="1"
                @if ($user->notify == 1 ) checked @endif >
              <label class="form-check-label" for="accType1">
                Enable
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="notify" id="notify2" value="0"
                @if ($user->notify == 0 ) checked @endif >
              <label class="form-check-label" for="accType2">
                Disable
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="threshold">Threshold (KES) <small>(when your account balance goes below this value, a notification SMS will be sent to your number)</small></label>
            <input type="number" name="threshold" class="form-control" id="threshold" placeholder="Notify when balance is below?"
            value = "{{ $user->threshold ? : old('threshold') }}">
          </div>
          <div class="form-group">
            <label for="time">Notify Daily At</label>
            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
              <input type="text" name="time" class="form-control datetimepicker-input" data-target="#datetimepicker1" value = "{{ $user->time ? : old('time') }}"/>
              <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          
          <div class="form-group">
          <label for="timezone">Change Timezone</label>
          <select class="form-control select2" style="width: 100%;" name="timezone", id="timezone">
            <option></option>
          @foreach (timezone_identifiers_list() as $timezone)
                  <option value="{{ $timezone }}"{{ $user->timezone == $timezone ? ' selected' : old('timezone') }}>{{ $timezone }}</option>
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


<script type="text/javascript">

$.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
});

    $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'HH:mm'
        });
    });

</script>


@endsection
