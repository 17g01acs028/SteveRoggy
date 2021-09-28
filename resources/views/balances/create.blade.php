@extends('layouts.dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>TopUp Wallet</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
  <div class="col-lg-8 ">
    <!-- general form elements -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Top Up</h3>
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

      <form role="form" action="{{ route('balances.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div>
          <small>
          Enter the amount and your M-Pesa mobile number. <br> 
          A prompt to enter pin will popup on your phone. <br> 
          Enter pin to make the payment. <br>
          Your SynqSMS wallet will automatically get topped up after successful payment..
        </small>
          </div>
          <div class="form-group">
            <label for="amount">Amount (KES):</label>
            <input type="amount" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
          </div>
          <div class="form-group">
            <label for="phonenumber">Phone Number:</label><small>(phone number should begin with country code e.g. 254712345678)</small>
            <input type="text" name="phonenumber" class="form-control" id="phonenumber" placeholder="Enter Phone Number">
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
