@extends('layouts.dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Sender Price</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sender_prices.index') }}"> Back</a>
            </div>
        </div>
    </div>


<div class="row d-flex justify-content-center">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Showing Sender ID </h3>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="client_id">Client Name:</label>
            {{ $sender_price->client->clientName }}
        </div>
        <div class="form-group">
          <label for="sender">Sender ID:</label>
            {{ $sender_price->sender->name }}
        </div>
        <div class="form-group">
          <label for="price">Price per SMS:</label>
            {{ $sender_price->price }}
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
            {{ $sender_price->description }}
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a href="{{ route('sender_prices.index') }}/{{ id($sender_price->id) }}/edit" class="btn btn-primary" role="button" aria-pressed="true">Update</a>
      </div>
    </div>
  </div>
</div>
@endsection
