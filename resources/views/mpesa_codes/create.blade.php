@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>New Mpesa Code</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('mpesa_codes.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">New Mpesa Code</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
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

      <form role="form" action="{{ route('mpesa_codes.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="client">Client Name</label>
            <select class="form-control select2" style="width: 100%;" name="client", id="client">
              <option></option>
              @foreach ($clients as $cl)
              <option value="{{$cl->id}}" >{{ $cl->clientName }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="code">Mpesa Code</label>
            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Mpesa Code">
          </div>
          <div class="form-group">
            <label for="responseType">Response Type</label>
            <select class="form-control select2" style="width: 100%;" name="responseType", id="responseType">
              <option></option>
              @foreach ($responseType as $cl)
              <option value="{{$cl}}" >{{ $cl }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="confirmationURL">Confirmation URL</label>
            <select class="form-control select2" style="width: 100%;" name="confirmationURL", id="confirmationURL">
              <option></option>
              @foreach ($confirmationURL as $cl)
              <option value="{{$cl}}" >{{ $cl }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="validationURL">Validation URL</label>
            <select class="form-control select2" style="width: 100%;" name="validationURL", id="validationURL">
              <option></option>
              @foreach ($validationURL as $cl)
              <option value="{{$cl}}" >{{ $cl }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="consumerKey">Consumer Key</label>
            <input type="text" name="consumerKey" class="form-control" id="consumerKey" placeholder="Enter Consumer Key">
          </div>
          <div class="form-group">
            <label for="consumerSecret">Consumer Secret</label>
            <input type="text" name="consumerSecret" class="form-control" id="consumerSecret" placeholder="Enter Consumer Secret">
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
